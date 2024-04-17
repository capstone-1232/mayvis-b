<x-layout>
    <div class="content">
       <div class="container my-3">
          <div class="row justify-content-center my-4">
             <div class="col-lg-8">
                <h2 class="display-6 py-2 fw-bold">
                   <i class="bi bi-tag me-3"></i>Create Category
                </h2>
                <div class="bg-white p-4 rounded-5 shadow mt-4">
                   <form action="{{ route('categories.storeCategory') }}" method="POST">
                      @csrf
                      <div class="form-group mb-3 mt-2">
                         <x-input-label for="category_name"  :value="__('Category Name')" />
                         <x-text-input type="text" name="category_name" class="form-control" :value="old('category_name')"></x-text-input>
                      </div>
                      <x-input-error class="mt-2 productserr" :messages="$errors->get('category_name')" />
                      <div class="form-group mb-3">
                         <x-input-label for="notes"  :value="__('Category Notes (Optional)')" />
                         <textarea class="form-control" id="notes" name="notes"></textarea>
                      </div>
                      <x-input-error class="mt-2 productserr" :messages="$errors->get('notes')" />
                      <div class="form-group mb-3">
                         <x-input-label for="created_by"  :value="__('Created By')" />
                         <x-text-input type="text" name="created_by" class="form-control" value="{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}"></x-text-input>
                      </div>
                      <x-input-error class="mt-2 productserr" :messages="$errors->get('created_by')" />
                      <div class="d-flex justify-content-end align-items-center mt-4">
                         <a href="{{ route('index-category') }}" class="fs-7 fw-bold me-2">Cancel</a>
                         <x-primary-button type="submit" class="btn primary-btn text-white rounded-pill">Save Category</x-primary-button>
                      </div>
                   </form>
                </div>
             </div>
          </div>
       </div>
    </div>
 </x-layout>