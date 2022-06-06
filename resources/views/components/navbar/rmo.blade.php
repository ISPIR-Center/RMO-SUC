<div>
    <nav id="sidebar">
        <div class="pt-3">
    
          <ul class="nav flex-column list-group">
            <x-navbar.li :navstatus="$active" name="dashboard">
              <a class="nav-item-link" href="#"><ion-icon name="grid-outline" size="large"></ion-icon> Dashboard</a>
            </x-navbar.li>
              
            <x-navbar.li :navstatus="$active" name="rmorbp">
              <a href="#manageProposal" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-item-link"><ion-icon name="file-tray-full" size="large"></ion-icon> Approved Research</a>
              
              <div class="pl-4">
                  <ul class="collapse collapse-group list-unstyled" id="manageProposal">
                      <li class="collapse-item">
                          <a href="{{ route('rmo-rbp')}}"><ion-icon name="folder-outline" class="pr-2" size="medium"></ion-icon> Research Based Paper</a>
                      </li> 
                  </ul>
    
                  <ul class="collapse collapse-group list-unstyled" id="manageProposal">
                      <li class="collapse-item">
                          <a href="{{ route('rmo-invention')}}"><ion-icon name="folder-outline" class="pr-2" size="medium"></ion-icon> Invention</a>
                      </li>
                  </ul>
    
                  <ul class="collapse collapse-group list-unstyled" id="manageProposal">
                      <li class="collapse-item">
                          <a href="#"><ion-icon name="folder-outline" class="pr-2" size="medium"></ion-icon> Others</a>
                      </li>
                  </ul>
              </div>
          </x-navbar.li>
            
    
            <x-navbar.li :navstatus="$active" name="rmopending">
              <a class="nav-item-link" href="{{ route('rmo-pending') }}"><ion-icon name="document-text-outline" size="large"></ion-icon> Pending </a>
            </x-navbar.li>
    
              <x-navbar.li :navstatus="$active" name="rmorevision">
                <a class="nav-item-link" href="{{ route('rmo-revision') }}"><ion-icon name="document-text-outline" size="large"></ion-icon> For Revision </a>
              </x-navbar.li>

              <x-navbar.li :navstatus="$active" name="rmofaculty">
                <a class="nav-item-link" href="{{ route('rmo-faculty') }}"><ion-icon name="people-outline" size="large"></ion-icon> Researchers</a>
              </x-navbar.li>

              <x-navbar.li :navstatus="$active" name="rmosheet">
                <a class="nav-item-link" href="{{ route('rmo-sheet') }}"><ion-icon name="document-text-outline" size="large"></ion-icon> Generate Summary Sheet </a>
              </x-navbar.li>

              <x-navbar.li :navstatus="$active" name="rmoreport">
                <a class="nav-item-link" href="{{ route('rmo-report') }}"><ion-icon name="document-text-outline" size="large"></ion-icon> Generate Report </a>
              </x-navbar.li>
            
            
              <x-navbar.li :navstatus="$active" name="manageaccount">
                <a href="#manageAccount" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-item-link"><ion-icon name="settings-outline" size="large"></ion-icon> Manage Account</a>
                
                <ul class="collapse collapse-group list-unstyled" id="manageAccount">
                  <li class="collapse-item">
                      <a href="{{ route('rmo-change') }}"><ion-icon name="lock-open-outline" size="large"></ion-icon> Change Password</a>
                  </li>
              </ul>
            </x-navbar.li>
        
          </ul>
    
        </div>
      </nav>
      <footer class="page-footer pt-3">
        <div class="footer-nav-item">
          <a class="footer-nav-item-link" href="https://help.bulsu-ovprde.com/" target="_blank"
            ><ion-icon name="help-circle-outline" size="large"></ion-icon>Need Help?<span
              class="footer-subtitle"
              >Open our Help Center</span
            ></a
          >
        </div>
      </footer>
    </div>