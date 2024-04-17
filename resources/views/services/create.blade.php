<x-layout>
    <div class="content">
       <div class="container my-3">
          <div class="row justify-content-center my-4">
             <div class="col-lg-8">
                <h2 class="display-6 py-2 fw-bold">
                   <i class="bi bi-box-seam me-3"></i>Create New Product
                </h2>
                <div class="bg-white p-4 rounded-5 shadow mt-4">
                   <form action="{{ route('services.storeProduct') }}" method="POST">
                      @csrf
                      <div class="form-group mb-3 mt-2">
                         <x-input-label for="product_name" :value="__('Product Name')" />
                         <x-text-input type="text" name="product_name" class="form-control" :value="old('product_name')"></x-text-input>
                         <x-input-error class="mt-2 productserr" :messages="$errors->get('product_name')" />
                      </div>
                      <div class="form-group mb-3">
                         <x-input-label for="product_description" :value="__('Product Description')" />
                         <textarea type="text" name="product_description" class="form-control" :value="old('product_description')"></textarea>
                         <x-input-error class="mt-2 productserr" :messages="$errors->get('product_description')" />
                      </div>
                      <div class="form-group mb-3">
                         <x-input-label for="product_notes" :value="__('Product Notes (Optional)')" />
                         <x-text-input class="form-control" type="text" name="product_notes"></x-text-input>
                      </div>
                      <div class="form-group mb-3">
                         <x-input-label for="price" :value="__('Product Price')" />
                         <x-text-input type="text" name="price" class="form-control" :value="old('price')"></x-text-input>
                         <x-input-error class="mt-2 productserr" :messages="$errors->get('price')" />
                      </div>
                      <div class="form-group mb-3">
                         <x-input-label for="category_id" :value="__('Category')" />
                         <select name="category_id" id="category_id" class="form-control form-select rounded-pill">
                            @foreach ($categories as $category)
                            <option textarea class="form-control" value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                         </select>
                      </div>
                      <div class="form-group mb-3">
                         <x-input-label for="created_by" :value="__('Created By')" />
                         <x-text-input type="text" name="created_by" class="form-control" value="{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}"></x-text-input>
                         <x-input-error class="mt-2 productserr" :messages="$errors->get('created_by')" />
                      </div>
                      <div class="d-flex justify-content-end align-items-center mt-3">
                         <a href="{{ route('servicesIndex') }}" class="fs-7 fw-bold me-2">Cancel</a>
                         <x-primary-button type="submit" class="btn primary-btn text-white rounded-pill">Save Product</x-primary-button>
                      </div>
                   </form>
                </div>
             </div>
          </div>
       </div>
    </div>
 </x-layout>