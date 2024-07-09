@extends('front.app_front')

@section('content')

<div class="page-banner" style="background-image: url('{{ asset('uploads/page_banners/'.$property_category_page_data->banner) }}')">
    <div class="page-banner-bg"></div>
    <h1>{{ PROPERTY_CATEGORY_COLON }} {{ $property_category_detail->property_category_name }}</h1>
    <nav>
        <ol class="breadcrumb justify-content-center">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ HOME }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('front_property_category_all') }}">{{ $property_category_page_data->name }}</a></li>
            <li class="breadcrumb-item active">{{ $property_category_detail->property_category_name }}</li>
        </ol>
    </nav>
</div>

<div class="page-content">
    <div class="container">
        <div class="row property pt_0 pb_0">

            @if($property_items->isEmpty())
                <div class="text-danger">
                    {{ NO_RESULT_FOUND }}
                </div>
            @else
            @foreach($property_items as $row)

            @if($row->user_id !=0)
                @php
                    $t_data = \App\Models\PackagePurchase::where('user_id',$row->user_id)->where('currently_active',1)->first();
                @endphp
                @if($t_data->package_end_date < date('Y-m-d'))
                    @continue
                @endif
            @endif

            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="property-item">
                    <div class="photo">
                        <a href="{{ route('front_property_detail',$row->property_slug) }}"><img src="{{ asset('uploads/property_featured_photos/'.$row->property_featured_photo) }}" alt=""></a>
                        <div class="category">
                            <a href="{{ route('front_property_category_detail',$row->rPropertyCategory->property_category_slug) }}">{{ $row->rPropertyCategory->property_category_name }}</a>
                        </div>
                        <div class="wishlist">
                            <a href="{{ route('front_add_wishlist',$row->id) }}"><i class="fas fa-heart"></i></a>
                        </div>
                        @if($row->is_featured == 'Yes')
                        <div class="featured-text">{{ FEATURED }}</div>
                        @endif
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
                            <a href="{{ route('front_property_location_detail',$row->rPropertyLocation->property_location_slug) }}"><i class="fas fa-map-marker-alt"></i> {{ $row->rPropertyLocation->property_location_name }}</a>
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
            </div>
            @endforeach

                <div class="col-md-12">
                    {{ $property_items->links() }}
                </div>

            @endif

        </div>
    </div>
</div>

@endsection
