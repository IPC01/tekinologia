<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {

         $products = Product::with(['category', 'files'])->paginate(10);
         $categories = $products->filter(fn($product) => $product->category)->pluck('category')->unique('id')->values(); 
        return view('admin.pages.product.index', compact('products','categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.pages.product.create', compact('categories'));
    }

public function store(Request $request)
{
    try {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug',
            'description' => 'required|string',
            'excerpt' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'demo_url' => 'nullable|url',
            'category_id' => 'required|exists:categories,id',
            'author_id' => 'nullable|exists:users,id',
            'is_active' => 'sometimes|boolean',
            'is_featured' => 'sometimes|boolean',
            'tags' => 'nullable|string', // string separada por vírgulas
            'license' => 'nullable|string',
            'version' => 'nullable|string',
            'requirements' => 'nullable|string',
            'compatibility' => 'nullable|string',

            // arquivos
            'cover_image' => 'nullable|image|max:2048',
            'additional_images.*' => 'nullable|image|max:2048',
            'download_file' => 'nullable|file|max:10240',
        ]);

        // Ajusta booleanos (checkbox pode não estar no request)
        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');

        // Converte tags para JSON
        $tags = [];
        if (!empty($data['tags'])) {
            $tags = array_map('trim', explode(',', $data['tags']));
        }
        $data['tags'] = json_encode($tags);
        $data['user_id'] = auth()->user()->id;
        $data['author_id'] = auth()->user()->id;

        // Cria produto
        $product = Product::create($data);

        // Salva imagem de capa
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('products/images', 'public');
            $product->files()->create([
                'type' => 'cover_image',
                'file_path' => $path,
                'is_primary' => true,
            ]);
        }

        // Salva imagens adicionais
        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $image) {
                $path = $image->store('products/images', 'public');
                $product->files()->create([
                    'type' => 'additional_image',
                    'file_path' => $path,
                    'is_primary' => false,
                ]);
            }
        }

        // Salva arquivo download
        if ($request->hasFile('download_file')) {
            $path = $request->file('download_file')->store('products/files', 'public');
            $product->files()->create([
                'type' => 'download_file',
                'file_path' => $path,
                'is_primary' => false,
            ]);
        }

        return redirect()->route('products.index')->with('success', 'Produto criado com sucesso.');

    } catch (\Illuminate\Validation\ValidationException $e) {
        // Retorna erros de validação para a view automaticamente
        return redirect()->back()
                         ->withErrors($e->validator)
                         ->withInput();
    } catch (\Exception $e) {
        // Para outros erros, pode logar e mostrar mensagem genérica
        \Log::error('Erro ao criar produto: '.$e->getMessage());

        return redirect()->back()
                         ->with('error', 'Ocorreu um erro ao criar o produto. Tente novamente.')
                         ->withInput();
    }
}



    public function show(Product $product)
    {
        $product->load(['category', 'files']);
        return view('admin.pages.product.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.pages.product.edit', compact('product', 'categories'));
    }

public function update(Request $request, Product $product)
{
    try {
        $data = $request->validate([
            'title'           => 'required|string|max:255',
                      'slug' => 'required|string|:products,slug',

            'description'     => 'required|string',
            'excerpt'         => 'nullable|string',
            'price'           => 'required|numeric|min:0',
            'discount_price'  => 'nullable|numeric|min:0',
            'demo_url'        => 'nullable|url',
            'category_id'     => 'required|exists:categories,id',
            'author_id'       => 'nullable|exists:users,id',
            'is_active'       => 'sometimes|boolean',
            'is_featured'     => 'sometimes|boolean',
            'tags'            => 'nullable|string',
            'license'         => 'nullable|string',
            'version'         => 'nullable|string',
            'requirements'    => 'nullable|string',
            'compatibility'   => 'nullable|string',

            // arquivos
            'cover_image'         => 'nullable|image|max:2048',
            'additional_images.*' => 'nullable|image|max:2048',
            'download_file'       => 'nullable|file|max:10240',
        ]);

        // Ajusta booleanos
        $data['is_active']   = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');

        // Converte tags para JSON
        $data['tags'] = json_encode(
            collect(explode(',', $data['tags'] ?? ''))
                ->filter()
                ->map(fn ($tag) => trim($tag))
                ->values()
        );

        /* ------------------------------------------------------------------
         * 1. Atualiza campos simples do produto
         * -----------------------------------------------------------------*/
        $product->update($data);

        /* ------------------------------------------------------------------
         * 2. Substitui imagem de capa (se veio nova)
         * -----------------------------------------------------------------*/
        if ($request->hasFile('cover_image')) {
            // remove arquivo antigo e registro em 'files'
            $oldCover = $product->files()->where('type', 'cover_image')->first();
            if ($oldCover) {
                Storage::disk('public')->delete($oldCover->file_path);
                $oldCover->delete();
            }
            // salva a nova
            $path = $request->file('cover_image')->store('products/images', 'public');
            $product->files()->create([
                'type'       => 'cover_image',
                'file_path'  => $path,
                'is_primary' => true,
            ]);
        }

        /* ------------------------------------------------------------------
         * 3. Adiciona novas imagens adicionais
         * -----------------------------------------------------------------*/
        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $image) {
                $path = $image->store('products/images', 'public');
                $product->files()->create([
                    'type'       => 'additional_image',
                    'file_path'  => $path,
                    'is_primary' => false,
                ]);
            }
        }

        /* ------------------------------------------------------------------
         * 4. Substitui arquivo de download (se veio novo)
         * -----------------------------------------------------------------*/
        if ($request->hasFile('download_file')) {
            $oldDownload = $product->files()->where('type', 'download_file')->first();
            if ($oldDownload) {
                Storage::disk('public')->delete($oldDownload->file_path);
                $oldDownload->delete();
            }
            $path = $request->file('download_file')->store('products/files', 'public');
            $product->files()->create([
                'type'       => 'download_file',
                'file_path'  => $path,
                'is_primary' => false,
            ]);
        }

        return redirect()->route('products.index')
                         ->with('success', 'Produto atualizado com sucesso.');

    } catch (\Illuminate\Validation\ValidationException $e) {
        return back()->withErrors($e->validator)->withInput();
    } catch (\Exception $e) {
        \Log::error('Erro ao atualizar produto: '.$e->getMessage());
        return back()->with('error', 'Ocorreu um erro ao atualizar o produto.')->withInput();
    }
}

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted.');
    }
}
