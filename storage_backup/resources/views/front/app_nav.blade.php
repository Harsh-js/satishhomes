@php
$g_settings = \App\Models\GeneralSetting::where('id',1)->first();
$dynamic_pages = \App\Models\DynamicPage::get();
$page_about_item = \App\Models\PageAboutItem::where('id',1)->first();
$page_faq_item = \App\Models\PageFaqItem::where('id',1)->first();
$page_blog_item = \App\Models\PageBlogItem::where('id',1)->first();
$page_property_item = \App\Models\PagePropertyItem::where('id',1)->first();
$page_pricing_item = \App\Models\PagePricingItem::where('id',1)->first();
$page_contact_item = \App\Models\PageContactItem::where('id',1)->first();
$page_property_location_item = \App\Models\PagePropertyLocationItem::where('id',1)->first();
$page_property_category_item = \App\Models\PagePropertyCategoryItem::where('id',1)->first();
@endphp

<!-- Start Navbar Area -->
<div class="navbar-area" id="stickymenu">

	<!-- Menu For Mobile Device -->
	<div class="mobile-nav">
		<a href="{{ url('/') }}" class="logo">
			<img src="{{ asset('uploads/site_photos/'.$g_settings->logo) }}" alt="">
		</a>
	</div>

	<!-- Menu For Desktop Device -->
	<div class="main-nav">
		<div class="container">
			<nav class="navbar navbar-expand-md navbar-light">
				<a class="navbar-brand" href="{{ url('/') }}">
					<img src="{{ asset('uploads/site_photos/'.$g_settings->logo) }}" alt="">
				</a>
				<div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
					<ul class="navbar-nav {{ $g_settings->layout_direction == 'ltr' ? 'ml-auto' : 'mr-auto' }}">


						<li class="nav-item">
							<a href="{{ url('/') }}" class="nav-link">{{ MENU_HOME }}</a>
						</li>

                        @if($page_property_item->status == 'Show')
						<li class="nav-item">
							<a href="{{ url('property-result') }}" class="nav-link"  id="property-link">{{ MENU_PROPERTY }}</a>
						</li>
						<script>
							$(document).ready(function() {
								$('#property-link').on('click', function(event) {
									event.preventDefault();
									$('form').attr('action', $(this).attr('href'));
									$('form').submit();
								});
							});
						</script>
                        @endif

                        @if($page_pricing_item->status == 'Show')
						<li class="nav-item">
							<a href="{{ route('front_pricing') }}" class="nav-link">{{ MENU_PRICING }}</a>
						</li>
                        @endif


                        @if($page_about_item->status == 'Show' || $page_property_location_item->status == 'Show' || $page_faq_item->status == 'Show' || $page_property_category_item->status == 'Show' || (!$dynamic_pages->isEmpty()))
						<li class="nav-item">
							<a href="javascript:void;" class="nav-link dropdown-toggle">{{ MENU_PAGES }}</a>
							<ul class="dropdown-menu">

                                @if($page_about_item->status == 'Show')
								<li class="nav-item">
									<a href="{{ route('front_about') }}" class="nav-link">{{ MENU_ABOUT }}</a>
								</li>
                                @endif

                                @if($page_property_location_item->status == 'Show')
								<li class="nav-item">
									<a href="{{ route('front_property_location_all') }}" class="nav-link">{{ MENU_LOCATION }}</a>
								</li>
                                @endif

                                @if($page_faq_item->status == 'Show')
								<li class="nav-item">
									<a href="{{ route('front_faq') }}" class="nav-link">{{ MENU_FAQ }}</a>
								</li>
                                @endif

                                @if($page_property_category_item->status == 'Show')
								<li class="nav-item">
									<a href="{{ route('front_property_category_all') }}" class="nav-link">{{ MENU_CATEGORY }}</a>
								</li>
                                @endif

                                @if(!$dynamic_pages->isEmpty())
								@foreach($dynamic_pages as $row)
                                    <li class="nav-item">
                                        <a href="{{ url('page/'.$row->dynamic_page_slug) }}" class="nav-link">{{ $row->dynamic_page_name }}</a>
                                    </li>
                                @endforeach
                                @endif
							</ul>
						</li>
                        @endif

						@if($page_blog_item->status == 'Show')
						<li class="nav-item">
							<a href="{{ route('front_blogs') }}" class="nav-link">{{ MENU_BLOG }}</a>
						</li>
						@endif

                        @if($page_contact_item->status == 'Show')
						<li class="nav-item">
							<a href="{{ route('front_contact') }}" class="nav-link">{{ MENU_CONTACT }}</a>
						</li>
                        @endif

					</ul>
				</div>
			</nav>
		</div>
	</div>
</div>
<!-- End Navbar Area -->
