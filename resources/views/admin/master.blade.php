@php
	$dir=App::getLocale() == 'ar' ? 'rtl' : '';
@endphp
<!DOCTYPE html>

<html lang="en">
@include('admin.partials.head')

<body dir={{ $dir }}>
    <div class="main-wrapper">

        @include('admin.partials.sidebar')



        <!-- partial -->

        <div class="page-wrapper">

            @include('admin.partials.navbar')


            <div class="page-content">

                <div class="flex-wrap d-flex justify-content-between align-items-center grid-margin">
                    <div>
                        <h4 class="mb-3 mb-md-0">Welcome to Dashboard</h4>
                    </div>
                    <div class="flex-wrap d-flex align-items-center text-nowrap">

                        {{-- Can put button or any think in this place --}}
                    </div>
                </div>
                @yield('content')


            </div>

            @include('admin.partials.footer')


        </div>
    </div>
    @include('admin.partials.scripts')


</body>

</html>
