<!-- Dropdown Menu -->
<div class="dropdown">
    <a class="nav-link dropdown-toggle " type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
{{--        <img src="{{ asset('vendor/blade-flags/language-' . LaravelLocalization::getCurrentLocale() . '.svg') }}"--}}
{{--            width="20" height="20">--}}
        <i data-feather="globe"></i>
{{--        <span class="ms-1 me-1 d-none d-md-inline-block">{{ LaravelLocalization::getCurrentLocaleNative() }}</span>--}}
    </a>

    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            <a rel="alternate" hreflang="{{ $localeCode }}"
                href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                class="py-2 dropdown-item">

                <img src="{{ asset('vendor/blade-flags/language-' . $localeCode . '.svg') }}" width="20"
                    height="20" class="mx-2" />
                {{ $properties['native'] }}

            </a>
        @endforeach
    </div>
</div>
