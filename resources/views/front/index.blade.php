@extends('front.app_front')

@section('content')

<div class="search-section" style="background-image:url('{{ asset('uploads/site_photos/'.$page_home_items->search_background) }}');">
	<div class="bg"></div>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1>{{ $page_home_items->search_heading }}</h1>
				<p>
					{{ $page_home_items->search_text }}
				</p>
				<div class="box">
					<form action="{{ url('property-result') }}" method="POST">
						@csrf
						<div class="input-group input-box mb-3">
							<input type="text" class="form-control" placeholder="{{ FIND_ANYTHING }}" name="text">
							<select name="location[]" class="form-control select2">
								<option value="">{{ SELECT_LOCATION }}</option>
								@foreach($property_locations as $row)
									<option value="{{ $row->id }}">{{ $row->property_location_name }}</option>
								@endforeach
							</select>
							<select name="category[]" class="form-control select2">
								<option value="">{{ SELECT_CATEGORY }}</option>
								@foreach($property_categories as $row)
									<option value="{{ $row->id }}">{{ $row->property_category_name }}</option>
								@endforeach
							</select>
							<select name="property_type" class="form-control select2">
								<option value="">{{ SELECT_TYPE }}</option>
								<option value="sale">{{ FOR_SALE }}</option>
								<option value="rent">{{ FOR_RENT }}</option>
							</select>
							<div class="input-group-append">
								<button type="submit"><i class="fa fa-search"></i> {{ SEARCH }}</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>


@if($adv_home_data->above_category_status == 'Show')
<div class="ad-section">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-sm-12">
				<div class="inner">
					@if($adv_home_data->above_category_1_url == '')
						<img src="{{ asset('uploads/advertisements/'.$adv_home_data->above_category_1) }}" alt="">
					@else
						<a href="{{ $adv_home_data->above_category_1_url }}" target="_blank"><img src="{{ asset('uploads/advertisements/'.$adv_home_data->above_category_1) }}" alt=""></a>
					@endif
				</div>
			</div>
			<div class="col-md-6 col-sm-12">
				<div class="inner">
					@if($adv_home_data->above_category_2_url == '')
						<img src="{{ asset('uploads/advertisements/'.$adv_home_data->above_category_2) }}" alt="">
					@else
						<a href="{{ $adv_home_data->above_category_2_url }}" target="_blank"><img src="{{ asset('uploads/advertisements/'.$adv_home_data->above_category_2) }}" alt=""></a>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endif


@if($page_home_items->category_status == 'Show')
<div class="popular-category">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="heading">
					<h2>{{ $page_home_items->category_heading }}</h2>
					<h3>{{ $page_home_items->category_subheading }}</h3>
				</div>
			</div>
		</div>
		<div class="row">
            @php $i=0; @endphp
			@foreach($orderwise_property_categories as $row)
                @php $i++; @endphp
                @if($i>$page_home_items->category_total)
                    @break;
                @endif

				@if($row->total == '')
        		@php $row->total = 0; @endphp
        		@endif
				<div class="col-lg-4 col-md-6 col-sm-6">
					<div class="popular-category-item" style="background-image: url({{ asset('uploads/property_category_photos/'.$row->property_category_photo) }});">
						<div class="bg"></div>
						<div class="text">
							<h4>{{ $row->property_category_name }}</h4>

                            @php
                                $qty = 0;
                                $categoryProperties = App\Models\Property::where('property_category_id', $row->id)->where('property_status','Active')->get();
                                foreach ($categoryProperties as $key => $categoryProperty) {
                                    if($categoryProperty->user_id != 0){
                                        $activePackage = App\Models\PackagePurchase::where('user_id',$categoryProperty->user_id)->where('currently_active',1)->first();
                                        if($activePackage->package_end_date >= date('Y-m-d')){
                                            $qty += 1;
                                        }
                                    }else{
                                        $qty += 1;
                                    }
                                }
                            @endphp


							<p>{{ $qty }} {{ PROPERTIES }}</p>
						</div>
						<a href="{{ route('front_property_category_detail',$row->property_category_slug) }}"></a>
					</div>
				</div>
			@endforeach
		</div>
	</div>
</div>
@endif


@if($adv_home_data->above_featured_property_status == 'Show')
<div class="ad-section">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-sm-12">
				<div class="inner">
					@if($adv_home_data->above_featured_property_1_url == '')
						<img src="{{ asset('uploads/advertisements/'.$adv_home_data->above_featured_property_1) }}" alt="">
					@else
						<a href="{{ $adv_home_data->above_featured_property_1_url }}" target="_blank"><img src="{{ asset('uploads/advertisements/'.$adv_home_data->above_featured_property_1) }}" alt=""></a>
					@endif
				</div>
			</div>
			<div class="col-md-6 col-sm-12">
				<div class="inner">
					@if($adv_home_data->above_featured_property_2_url == '')
						<img src="{{ asset('uploads/advertisements/'.$adv_home_data->above_featured_property_2) }}" alt="">
					@else
						<a href="{{ $adv_home_data->above_featured_property_2_url }}" target="_blank"><img src="{{ asset('uploads/advertisements/'.$adv_home_data->above_featured_property_2) }}" alt=""></a>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endif


@if($page_home_items->property_status == 'Show')
<div class="property">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="heading">
					<h2>{{ $page_home_items->property_heading }}</h2>
					<h3>{{ $page_home_items->property_subheading }}</h3>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="property-carousel owl-carousel">
					@php $i=0; @endphp
					@foreach($properties as $row)
					@php $i++; @endphp
					@if($i>$page_home_items->property_total)
						@break;
					@endif
					<div class="property-item">
						<div class="photo">
							<a href="{{ route('front_property_detail',$row->property_slug) }}"><img src="{{ asset('uploads/property_featured_photos/'.$row->property_featured_photo) }}" alt=""></a>
							<div class="category">
								<a href="{{ route('front_property_category_detail',$row->rPropertyCategory->property_category_slug) }}">{{ $row->rPropertyCategory->property_category_name }}</a>
							</div>
							<div class="wishlist">
								<a href="{{ route('front_add_wishlist',$row->id) }}"><i class="fas fa-heart"></i></a>
							</div>
                            <div class="featured-text">{{ FEATURED }}</div>
						</div>
						<div class="text">

							<div class="type-price">
								<div class="type">
									<div class="@if($row->property_type == 'For Sale') inner-sale @else inner-rent @endif">
										{{ $row->property_type }}
									</div>
								</div>
								<div class="price">
									@if(!session()->get('currency_symbol'))
										${{ number_format($row->property_price) }}
									@else
										{{ session()->get('currency_symbol') }}{{ number_format($row->property_price*session()->get('currency_value')) }}
									@endif
								</div>
							</div>

							<h3><a href="{{ route('front_property_detail',$row->property_slug) }}">{{ $row->property_name }}</a></h3>
							<div class="location">
								<i class="fas fa-map-marker-alt"></i> {{ $row->rPropertyLocation->property_location_name }}
							</div>

                            @php
                                $count=0;
                                $total_number = 0;
                                $overall_rating = 0;
                                $reviews = \App\Models\Review::where('property_id',$row->id)->get();
                            @endphp

                            @if($reviews->isEmpty())

                            @else

                            @foreach($reviews as $item)
                                @php
                                    $count++;
                                    $total_number = $total_number + $item->rating;
                                @endphp
                            @endforeach

                            @php
                                $overall_rating = $total_number/$count;
                            @endphp

                            @if($overall_rating>0 && $overall_rating<=1)
                                @php $overall_rating = 1; @endphp

                            @elseif($overall_rating>1 && $overall_rating<=1.5)
                                @php $overall_rating = 1.5; @endphp

                            @elseif($overall_rating>1.5 && $overall_rating<=2)
                                @php $overall_rating = 2; @endphp

                            @elseif($overall_rating>2 && $overall_rating<=2.5)
                                @php $overall_rating = 2.5; @endphp

                            @elseif($overall_rating>2.5 && $overall_rating<=3)
                                @php $overall_rating = 3; @endphp

                            @elseif($overall_rating>3 && $overall_rating<=3.5)
                                @php $overall_rating = 3.5; @endphp

                            @elseif($overall_rating>3.5 && $overall_rating<=4)
                                @php $overall_rating = 4; @endphp

                            @elseif($overall_rating>4 && $overall_rating<=4.5)
                                @php $overall_rating = 4.5; @endphp

                            @elseif($overall_rating>4.5 && $overall_rating<=5)
                                @php $overall_rating = 5; @endphp

                            @endif

                            @endif

							<div class="review">
                                @if($overall_rating == 5)
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                @elseif($overall_rating == 4.5)
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                @elseif($overall_rating == 4)
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                @elseif($overall_rating == 3.5)
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <i class="far fa-star"></i>
                                @elseif($overall_rating == 3)
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                @elseif($overall_rating == 2.5)
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                @elseif($overall_rating == 2)
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                @elseif($overall_rating == 1.5)
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                @elseif($overall_rating == 1)
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                @elseif($overall_rating == 0)
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                @endif
								<span>({{ $count }} {{ REVIEWS }})</span>
							</div>

							<div class="bed-bath-size">
								<div class="item">
									<div class="icon"><i class="fas fa-bed"></i></div>
									<div class="text">{{ $row->property_bedroom }} {{ BED }}</div>
								</div>
								<div class="item">
									<div class="icon"><i class="fas fa-bath"></i></div>
									<div class="text">{{ $row->property_bathroom }} {{ BATH }}</div>
								</div>
								<div class="item">
									<div class="icon"><i class="fab fa-squarespace"></i></div>
									<div class="text">{{ $row->property_size }}</div>
								</div>
							</div>

						</div>
					</div>
					@endforeach

				</div>
			</div>
		</div>
	</div>
</div>
@endif


@if($page_home_items->testimonial_status == 'Show')
<div class="testimonial" style="background-image:url('{{ asset('uploads/site_photos/'.$page_home_items->testimonial_background) }}');">
    <div class="testimonial-bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading">
                    <h2>{{ $page_home_items->testimonial_heading }}</h2>
					<h3>{{ $page_home_items->testimonial_subheading }}</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="testimonial-carousel owl-carousel">
					@foreach($testimonials as $row)
					<div class="testimonial-item">
                        <div class="photo">
                            <img src="{{ asset('uploads/testimonials/'.$row->photo) }}" alt="">
                        </div>
                        <div class="text">
                            <p>
                                {!! clean(nl2br($row->comment)) !!}
                            </p>
                            <h3>{{ $row->name }}</h3>
                            <h4>{{ $row->designation }}</h4>
                        </div>
                    </div>
					@endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif



@if($adv_home_data->above_location_status == 'Show')
<div class="ad-section">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-sm-12">
				<div class="inner">
					@if($adv_home_data->above_location_1_url == '')
						<img src="{{ asset('uploads/advertisements/'.$adv_home_data->above_location_1) }}" alt="">
					@else
						<a href="{{ $adv_home_data->above_location_1_url }}" target="_blank"><img src="{{ asset('uploads/advertisements/'.$adv_home_data->above_location_1) }}" alt=""></a>
					@endif
				</div>
			</div>
			<div class="col-md-6 col-sm-12">
				<div class="inner">
					@if($adv_home_data->above_location_2_url == '')
						<img src="{{ asset('uploads/advertisements/'.$adv_home_data->above_location_2) }}" alt="">
					@else
						<a href="{{ $adv_home_data->above_location_2_url }}" target="_blank"><img src="{{ asset('uploads/advertisements/'.$adv_home_data->above_location_2) }}" alt=""></a>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endif


@if($page_home_items->location_status == 'Show')
<div class="popular-city">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="heading">
					<h2>{{ $page_home_items->location_heading }}</h2>
					<h3>{{ $page_home_items->location_subheading }}</h3>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="popular-city-carousel owl-carousel">
                    @php $i=0; @endphp
					@foreach($orderwise_property_locations as $row)
                    @php $i++; @endphp
                    @if($i>$page_home_items->location_total)
                        @break;
                    @endif
					@if($row->total == '')
	        		@php $row->total = 0; @endphp
	        		@endif
					<div class="popular-city-item" style="background-image: url('{{ asset('uploads/property_location_photos/'.$row->property_location_photo) }}');">
						<div class="bg"></div>
						<div class="text">
							<h4>{{ $row->property_location_name }}</h4>

                            @php
                                $qty = 0;
                                $locationProperties = App\Models\Property::where('property_location_id', $row->id)->where('property_status','Active')->get();
                                foreach ($locationProperties as $key => $categoryProperty) {
                                    if($categoryProperty->user_id != 0){
                                        $activePackage = App\Models\PackagePurchase::where('user_id',$categoryProperty->user_id)->where('currently_active',1)->first();
                                        if($activePackage->package_end_date >= date('Y-m-d')){
                                            $qty += 1;
                                        }
                                    }else{
                                        $qty += 1;
                                    }
                                }
                            @endphp

							<p>{{ $qty }} {{ PROPERTIES }}</p>
						</div>
						<a href="{{ route('front_property_location_detail',$row->property_location_slug) }}"></a>
					</div>
					@endforeach
				</div>
			</div>

		</div>
	</div>
</div>
@endif

{{-- <div class="ad-section">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-sm-12">
				<div class="inner">
					<a href=""><img src="{{ asset('images/ad1.jpg') }}" alt=""></a>
				</div>
			</div>
			<div class="col-md-6 col-sm-12">
				<div class="inner">
					<a href=""><img src="{{ asset('images/ad2.jpg') }}" alt=""></a>
				</div>
			</div>
		</div>
	</div>
</div> --}}

@endsection
