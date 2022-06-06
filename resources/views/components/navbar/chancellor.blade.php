<div>
    <nav id="sidebar">
        <div class="pt-3">
    
          <ul class="nav flex-column list-group">
            <x-navbar.li :navstatus="$active" name="dashboard">
              <a class="nav-item-link" href="#"><ion-icon name="grid-outline" size="large"></ion-icon> Dashboard</a>
            </x-navbar.li>
            
    
            <x-navbar.li :navstatus="$active" name="chancellorrbp">
              <a href="#manageProposal" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-item-link"><ion-icon name="file-tray-full" size="large"></ion-icon> Approved Research</a>
              
              <div class="pl-4">
                  <ul class="collapse collapse-group list-unstyled" id="manageProposal">
                      <li class="collapse-item">
                          <a href="{{ route('chancellor-rbp')}}"><ion-icon name="folder-outline" class="pr-2" size="medium"></ion-icon> Research Based Paper</a>
                      </li> 
                  </ul>
    
                  <ul class="collapse collapse-group list-unstyled" id="manageProposal">
                      <li class="collapse-item">
                          <a href="#"><ion-icon name="folder-outline" class="pr-2" size="medium"></ion-icon> Invention</a>
                      </li>
                  </ul>
    
                  <ul class="collapse collapse-group list-unstyled" id="manageProposal">
                      <li class="collapse-item">
                          <a href="#"><ion-icon name="folder-outline" class="pr-2" size="medium"></ion-icon> Others</a>
                      </li>
                  </ul>
              </div>
          </x-navbar.li>
            
    
            <x-navbar.li :navstatus="$active" name="chancellorpending">
              <a class="nav-item-link" href="{{ route('chancellor-pending') }}"><ion-icon name="document-text-outline" size="large"></ion-icon> Pending </a>
            </x-navbar.li>
    
              <x-navbar.li :navstatus="$active" name="chancellorrevision">
                <a class="nav-item-link" href="{{ route('chancellor-revision') }}"><ion-icon name="document-text-outline" size="large"></ion-icon>For Revision </a>
              </x-navbar.li>
            
            
              <x-navbar.li :navstatus="$active" name="chancellorchangepassword">
                      <a href="{{ route('chancellor-change') }}"><ion-icon name="lock-open-outline" size="large"></ion-icon> Change Password</a>
                 
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