  <!-- partial:partials/_sidebar.html -->
  <nav class="sidebar">
      <div class="sidebar-header">
          <a href="{{ route('admin.index') }}" class="sidebar-brand">
              Smart<span>School</span>
          </a>
          <div class="sidebar-toggler not-active">
              <span></span>
              <span></span>
              <span></span>
          </div>
      </div>
      <div class="sidebar-body">
          <ul class="nav">

              <x-singletab-component title="main" href="{{ route('admin.index') }}"
                  tabname="{{ __('keywords.dashboard') }}" icon="grid"></x-singletab-component>



              {{-- <li class="nav-item nav-category">{{ __('keywords.grade_list') }}</li> --}}
              <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="collapse" href="#emails" role="button" aria-expanded="false"
                      aria-controls="emails">
                      <i class="link-icon" data-feather="feather"></i>
                      <span class="link-title">{{ __('keywords.grade_list') }}</span>
                      <i class="link-arrow" data-feather="chevron-down"></i>
                  </a>
                  <div class="collapse" id="emails">
                      <ul class="nav sub-menu">
                          <li class="nav-item">
                              <a href="{{ route('admin.grades.index') }}"
                                  class="nav-link">{{ __('keywords.add_new_grade') }}</a>
                          </li>

                      </ul>
                  </div>
              </li>
              {{-- /* -------------------------------- Classroom ------------------------------- */ --}}
              {{-- <li class="nav-item nav-category">{{ __('keywords.classroom') }}</li> --}}
              <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="collapse" href="#classroom" role="button" aria-expanded="false"
                      aria-controls="emails">
                      <i class="link-icon" data-feather="feather"></i>
                      <span class="link-title">{{ __('keywords.classroom_list') }}</span>
                      <i class="link-arrow" data-feather="chevron-down"></i>
                  </a>
                  <div class="collapse" id="classroom">
                      <ul class="nav sub-menu">
                          <li class="nav-item">
                              <a href="{{ route('admin.classrooms.index') }}"
                                  class="nav-link">{{ __('keywords.add_new_classroom') }}</a>
                          </li>

                      </ul>
                  </div>
              </li>          
              {{-- /* -------------------------------- Sections ------------------------------- */ --}}
              {{-- <li class="nav-item nav-category">{{ __('keywords.sections') }}</li> --}}
              <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="collapse" href="#sections" role="button" aria-expanded="false"
                      aria-controls="emails">
                      <i class="link-icon" data-feather="feather"></i>
                      <span class="link-title">{{ __('keywords.sections_list') }}</span>
                      <i class="link-arrow" data-feather="chevron-down"></i>
                  </a>
                  <div class="collapse" id="sections">
                      <ul class="nav sub-menu">
                          <li class="nav-item">
                              <a href="{{ route('admin.classrooms.index') }}"
                                  class="nav-link">{{ __('keywords.add_new_section') }}</a>
                          </li>

                      </ul>
                  </div>
              </li>          
          </ul>



      </div>
  </nav>
