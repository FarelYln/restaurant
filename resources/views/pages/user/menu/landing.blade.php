<!-- Menu Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h5 class="section-title ff-secondary text-center text-primary fw-normal">Menu Makanan</h5>
            <h1 class="mb-5">Item Paling Populer</h1>
        </div>
        <div class="tab-class text-center wow fadeInUp" data-wow-delay="0.1s">
            <div class="tab-content">
                <div id="tab-1" class="tab-pane fade show p-0 active">
                    <div class="row g-4">
                        @foreach ($menus as $menu)
                        <div class="col-lg-6">
                            <div class="d-flex align-items-center">
                                <img class="flex-shrink-0 img-fluid rounded"
                                    src="{{ asset('storage/menu/' . $menu->image) }}" alt=""
                                    style="width: 80px;">
                                <div class="w-100 d-flex flex-column text-start ps-4">
                                    <h5 class="d-flex justify-content-between border-bottom pb-2">
                                        <span>{{ $menu->nama_menu }}</span>
                                        <span class="text-primary">${{ $menu->harga }}</span>
                                    </h5>
                                    <small class="fst-italic">Kategori: 
                                        @foreach ($menu->categories as $category)
                                            {{ $category->name }}@if (!$loop->last), @endif
                                        @endforeach
                                    </small>
                                    <small class="fst-italic d-block mt-2">Rating Rata-rata: {{ $menu->averageRating ?? 'Belum ada rating' }}</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Menu End -->
