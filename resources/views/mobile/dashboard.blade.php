@extends('mobile.main')

@section('content')
  <div id="content">
    <!-- ===================================
        START THE HEADER
      ==================================== -->
    <header class="default heade-sticky">
      <a href="index.html">
        <div class="un-item-logo">
          <img class="logo-img light-mode" src="{{ asset('assets/img/mahad/abuubaidah_circle.svg') }}" alt="">
          <img class="logo-img dark-mode" src="{{ asset('assets/img/mahad/abuubaidah_circle.svg') }}" alt="">
        </div>
      </a>
      <div class="un-block-right">
        <div class="un-notification">
          <a href="page-activity.html" aria-label="activity">
            <i class="ri-notification-line"></i>
          </a>
          <span class="bull-activity"></span>
        </div>
        <div class="un-user-profile">
          <a href="page-my-profile.html" aria-label="profile">
            <picture>
              <source srcset="{{ asset('mobile/images/avatar/11.webp') }}" type="image/webp">
              <img class="img-avatar" src="{{ asset('mobile/images/avatar/11.jpg') }}" alt="">
            </picture>
          </a>
        </div>
        <!-- menu-sidebar -->
        <div class="menu-sidebar">
          <button type="button" name="sidebarMenu" aria-label="sidebarMenu" class="btn" data-bs-toggle="modal"
            data-bs-target="#mdllSidebar-connected">
            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="9.3" viewBox="0 0 19 9.3">
              <g id="Group_8081" data-name="Group 8081" transform="translate(-329 -37)">
                <rect id="Rectangle_3986" data-name="Rectangle 3986" width="19" height="2.3" rx="1.15"
                  transform="translate(329 37)" fill="#222032" />
                <rect id="Rectangle_3987" data-name="Rectangle 3987" width="19" height="2.3" rx="1.15"
                  transform="translate(329 44)" fill="#222032" />
              </g>
            </svg>
          </button>
        </div>
      </div>
    </header>
    <!-- ===================================
        START THE SPACE STICKY
      ==================================== -->
    <div class="space-sticky"></div>
    <!-- ===================================
        START THE NFT SWIPER
      ==================================== -->
    <section class="unSwiper-cards margin-t-20">
      <div class="content-cards-NFTs margin-t-20">
        <div class="swiper cardGradual">
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <!-- item-card-gradual -->
              <div class="item-card-gradual">
                <div class="head-card d-flex justify-content-between align-items-center">
                  <div class="creator-name">
                    {{-- <div class="image-user">
                      <picture>
                        <source srcset="{{ asset('mobile/images/avatar/5.webp') }}" type="image/webp">
                        <img class="img-avatar" src="{{ asset('mobile/images/avatar/5.png') }}" alt="">
                      </picture>
                      <div class="icon">
                        <i class="ri-checkbox-circle-fill"></i>
                      </div>
                    </div> --}}
                    <h3>Tahsin Tilawah Al-Qur'an</h3>
                  </div>
                  <div class="btn-like-click">
                    <div class="btnLike">
                      <input type="checkbox">
                      <span class="count-likes">195</span>
                      <i class="ri-heart-3-line"></i>
                    </div>
                  </div>
                </div>
                <a href="page-collectibles-details.html" class="body-card py-0">
                  <div class="cover-nft">
                    <picture>
                      <source srcset="{{ asset('mobile/images/other/26.webp') }}" type="image/webp">
                      <img class="img-cover" src="{{ asset('mobile/images/other/26.jpg') }}" alt="image NFT">
                    </picture>
                    <div class="icon-type">
                      <i class="ri-vidicon-line"></i>
                    </div>
                    <div class="countdown-time">
                      <span>08H 38M 16S</span>
                    </div>
                  </div>
                  <div class="title-card-nft">
                    <div class="side-one">
                      <h2>The Dark Corner</h2>
                      <p>8 Editions Minted</p>
                    </div>
                    <div class="side-other">
                      <span class="no-sales">3 for sale</span>
                    </div>
                  </div>

                </a>
                <div class="footer-card">
                  <div class="starting-bad">
                    <h4>2.78 ETH</h4>
                    <span>Starting Bid</span>
                  </div>
                  <button type="button" class="btn btn-md-size bg-primary text-white rounded-pill">
                    Place a bid
                  </button>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <!-- item-card-gradual -->
              <div class="item-card-gradual">
                <div class="head-card d-flex justify-content-between align-items-center">
                  <div class="creator-name">
                    <div class="image-user">
                      <picture>
                        <source srcset="{{ asset('mobile/images/avatar/21.webp') }}" type="image/webp">
                        <img class="img-avatar" src="{{ asset('mobile/images/avatar/21.jpg') }}" alt="">
                      </picture>
                      <div class="icon">
                        <i class="ri-checkbox-circle-fill"></i>
                      </div>
                    </div>
                    <h3>Leda Beneventi</h3>
                  </div>
                  <div class="btn-like-click">
                    <div class="btnLike">
                      <input type="checkbox" checked>
                      <span class="count-likes">164</span>
                      <i class="ri-heart-3-line"></i>
                    </div>
                  </div>
                </div>
                <a href="page-collectibles-details.html" class="body-card py-0">
                  <div class="cover-nft">
                    <picture>
                      <source srcset="{{ asset('mobile/images/other/14.webp') }}" type="image/webp">
                      <img class="img-cover" src="{{ asset('mobile/images/other/14.jpg" alt="im') }}age NFT">
                    </picture>
                    <div class="countdown-time">
                      <span>08H 38M 16S</span>
                    </div>
                  </div>
                  <div class="title-card-nft">
                    <div class="side-one">
                      <h2>Galaxy on Earth</h2>
                      <p>6 Editions Minted</p>
                    </div>
                    <div class="side-other">
                      <span class="no-sales">2 for sale</span>
                    </div>
                  </div>
                </a>
                <div class="footer-card">
                  <div class="starting-bad">
                    <h4>2.40 ETH</h4>
                    <span>Starting Bid</span>
                  </div>
                  <button type="button" class="btn btn-md-size bg-primary text-white rounded-pill">
                    Place a bid
                  </button>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <!-- item-card-gradual -->
              <div class="item-card-gradual">
                <div class="head-card d-flex justify-content-between align-items-center">
                  <div class="creator-name">
                    <div class="image-user">
                      <picture>
                        <source srcset="{{ asset('mobile/images/avatar/13.webp') }}" type="image/webp">
                        <img class="img-avatar" src="{{ asset('mobile/images/avatar/13.jpg') }}" alt="">
                      </picture>
                      <div class="icon">
                        <i class="ri-checkbox-circle-fill"></i>
                      </div>
                    </div>
                    <h3>Bruce Wheless</h3>
                  </div>
                  <div class="btn-like-click">
                    <div class="btnLike">
                      <input type="checkbox">
                      <span class="count-likes">95</span>
                      <i class="ri-heart-3-line"></i>
                    </div>
                  </div>
                </div>
                <a href="page-collectibles-details.html" class="body-card py-0">
                  <div class="cover-nft">
                    <picture>
                      <source srcset="{{ asset('mobile/images/other/27.webp') }}" type="image/webp">
                      <img class="img-cover" src="{{ asset('mobile/images/other/27.jpg" alt="im') }}age NFT">
                    </picture>
                    <div class="countdown-time">
                      <span>08H 38M 16S</span>
                    </div>
                  </div>
                  <div class="title-card-nft">
                    <div class="side-one">
                      <h2>The Scary Shib</h2>
                      <p>8 Editions Minted</p>
                    </div>
                    <div class="side-other">
                      <span class="no-sales">3 for sale</span>
                    </div>
                  </div>
                </a>
                <div class="footer-card">
                  <div class="starting-bad">
                    <h4>1.27 ETH</h4>
                    <span>Starting Bid</span>
                  </div>
                  <button type="button" class="btn btn-md-size bg-primary text-white rounded-pill">
                    Place a bid
                  </button>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <!-- item-card-gradual -->
              <div class="item-card-gradual">
                <div class="head-card d-flex justify-content-between align-items-center">
                  <div class="creator-name">
                    <div class="image-user">
                      <picture>
                        <source srcset="{{ asset('mobile/images/avatar/17.webp') }}" type="image/webp">
                        <img class="img-avatar" src="{{ asset('mobile/images/avatar/17.jpg') }}" alt="">
                      </picture>
                      <div class="icon">
                        <i class="ri-checkbox-circle-fill"></i>
                      </div>
                    </div>
                    <h3>Steve Jones</h3>
                  </div>
                  <div class="btn-like-click">
                    <div class="btnLike">
                      <input type="checkbox">
                      <span class="count-likes">195</span>
                      <i class="ri-heart-3-line"></i>

                    </div>
                  </div>
                </div>
                <a href="page-collectibles-details.html" class="body-card py-0">
                  <div class="cover-nft">
                    <picture>
                      <source srcset="{{ asset('mobile/images/other/16.webp') }}" type="image/webp">
                      <img class="img-cover" src="{{ asset('mobile/images/other/16.jpg" alt="im') }}age NFT">
                    </picture>
                    <div class="icon-type">
                      <i class="ri-vidicon-line"></i>
                    </div>
                  </div>
                  <div class="title-card-nft">
                    <div class="side-one">
                      <h2>The Dark Corner</h2>
                      <p>25 Editions Minted</p>
                    </div>
                    <div class="side-other">
                      <span class="no-sales">5 for sale</span>
                    </div>
                  </div>
                </a>
                <div class="footer-card">
                  <div class="starting-bad">
                    <h4>1.29 ETH</h4>
                    <span>Starting Bid</span>
                  </div>
                  <button type="button" class="btn btn-md-size bg-primary text-white rounded-pill">
                    Place a bid
                  </button>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <!-- item-card-gradual -->
              <div class="item-card-gradual">
                <div class="head-card d-flex justify-content-between align-items-center">
                  <div class="creator-name">
                    <div class="image-user">
                      <picture>
                        <source srcset="{{ asset('mobile/images/avatar/19.webp') }}" type="image/webp">
                        <img class="img-avatar" src="{{ asset('mobile/images/avatar/19.jpg') }}" alt="">
                      </picture>
                      <div class="icon">
                        <i class="ri-checkbox-circle-fill"></i>
                      </div>
                    </div>
                    <h3>Hunter Taylor</h3>
                  </div>
                  <div class="btn-like-click">
                    <div class="btnLike">
                      <input type="checkbox">
                      <span class="count-likes">297</span>
                      <i class="ri-heart-3-line"></i>
                    </div>
                  </div>
                </div>
                <a href="page-collectibles-details.html" class="body-card py-0">
                  <div class="cover-nft">
                    <picture>
                      <source srcset="{{ asset('mobile/images/other/21.webp') }}" type="image/webp">
                      <img class="img-cover" src="{{ asset('mobile/images/other/21.jpg" alt="im') }}age NFT">
                    </picture>
                    <div class="countdown-time">
                      <span>08H 38M 16S</span>
                    </div>
                  </div>
                  <div class="title-card-nft">
                    <div class="side-one">
                      <h2>Ecstasy of the Dead</h2>
                      <p>350 Editions Minted</p>
                    </div>
                    <div class="side-other">
                      <span class="no-sales">9 for sale</span>
                    </div>
                  </div>
                </a>
                <div class="footer-card">
                  <div class="starting-bad">
                    <h4>1.79 ETH</h4>
                    <span>Starting Bid</span>
                  </div>
                  <button type="button" class="btn btn-md-size bg-primary text-white rounded-pill">
                    Place a bid
                  </button>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <!-- item-card-gradual -->
              <div class="item-card-gradual">
                <div class="head-card d-flex justify-content-between align-items-center">
                  <div class="creator-name">
                    <div class="image-user">
                      <picture>
                        <source srcset="{{ asset('mobile/images/avatar/18.webp') }}" type="image/webp">
                        <img class="img-avatar" src="{{ asset('mobile/images/avatar/18.jpg') }}" alt="">
                      </picture>
                      <div class="icon">
                        <i class="ri-checkbox-circle-fill"></i>
                      </div>
                    </div>
                    <h3>Craig Leach</h3>
                  </div>
                  <div class="btn-like-click">
                    <div class="btnLike">
                      <input type="checkbox">
                      <span class="count-likes">195</span>
                      <i class="ri-heart-3-line"></i>

                    </div>
                  </div>
                </div>
                <a href="page-collectibles-details.html" class="body-card py-0">
                  <div class="cover-nft">
                    <picture>
                      <source srcset="{{ asset('mobile/images/other/6.webp') }}" type="image/webp">
                      <img class="img-cover" src="{{ asset('mobile/images/other/6.jpg" alt="im') }}age NFT">
                    </picture>
                    <div class="icon-type">
                      <i class="ri-vidicon-line"></i>
                    </div>
                    <div class="countdown-time">
                      <span>08H 38M 16S</span>
                    </div>
                  </div>
                  <div class="title-card-nft">
                    <div class="side-one">
                      <h2>The Moon Boi</h2>
                      <p>14 Editions Minted</p>
                    </div>
                    <div class="side-other">
                      <span class="no-sales">2 for sale</span>
                    </div>
                  </div>

                </a>
                <div class="footer-card">
                  <div class="starting-bad">
                    <h4>2.78 ETH</h4>
                    <span>Starting Bid</span>
                  </div>
                  <button type="button" class="btn btn-md-size bg-primary text-white rounded-pill">
                    Place a bid
                  </button>

                </div>
              </div>
            </div>
          </div>
          <div class="swiper-button-next"></div>
          <div class="swiper-button-prev"></div>
        </div>
      </div>
    </section>
    <!-- ===================================
        START THE BEST SELLER
      ==================================== -->
    <section class="margin-t-20 unList-bestSeller">
      <!-- un-title-default -->
      <div class="un-title-default">
        <div class="text">
          <h2>Best Sellers</h2>
          <p>Best seller of this week's NFTs</p>
        </div>
        <div class="un-block-right">
          <a href="page-best-seller.html" class="icon-back" aria-label="iconBtn">
            <i class="ri-arrow-drop-right-line"></i>
          </a>
        </div>
      </div>

      <div class="content-list-sellers">
        <ul class="nav flex-column">
          <li class="nav-item">
            <div class="nav-link item-user-seller">
              <a href="page-creator-profile.html" class="item-user-img">
                <picture>
                  <source srcset="{{ asset('mobile/images/avatar/22.webp') }}" type="image/webp">
                  <img class="avt-img" src="{{ asset('mobile/images/avatar/22.jpg') }}" alt="">
                </picture>
                <div class="txt-user">
                  <h5>9.4 <span>ETH</span></h5>
                  <p>John Sullivan <i class="ri-checkbox-circle-fill"></i> </p>
                </div>
              </a>
              <div class="other-option">
                <button type="button" class="btn btn-box-check">
                  <input type="checkbox">
                  <div class="icon-box">
                    <i class="ri-add-fill"></i>
                  </div>
                </button>
              </div>
            </div>
          </li>
          <li class="nav-item">
            <div class="nav-link item-user-seller">
              <a href="page-creator-profile.html" class="item-user-img">
                <picture>
                  <source srcset="{{ asset('mobile/images/avatar/9.webp') }}" type="image/webp">
                  <img class="avt-img" src="{{ asset('mobile/images/avatar/9.jpg') }}" alt="">
                </picture>
                <div class="txt-user">
                  <h5>7.2 <span>ETH</span></h5>
                  <p>Doris Logue <i class="ri-checkbox-circle-fill"></i> </p>
                </div>
              </a>
              <div class="other-option">
                <button type="button" class="btn btn-box-check">
                  <input type="checkbox" checked>
                  <div class="icon-box">
                    <i class="ri-add-fill"></i>
                  </div>
                </button>
              </div>
            </div>
          </li>
          <li class="nav-item">
            <div class="nav-link item-user-seller">
              <a href="page-creator-profile.html" class="item-user-img">
                <picture>
                  <source srcset="{{ asset('mobile/images/avatar/16.webp') }}" type="image/webp">
                  <img class="avt-img" src="{{ asset('mobile/images/avatar/16.jpg') }}" alt="">
                </picture>
                <div class="txt-user">
                  <h5>6.8 <span>ETH</span></h5>
                  <p>James White <i class="ri-checkbox-circle-fill"></i> </p>
                </div>
              </a>
              <div class="other-option">
                <button type="button" class="btn btn-box-check">
                  <input type="checkbox">
                  <div class="icon-box">
                    <i class="ri-add-fill"></i>
                  </div>
                </button>
              </div>
            </div>
          </li>
          <li class="nav-item">
            <div class="nav-link item-user-seller">
              <a href="page-creator-profile.html" class="item-user-img">
                <picture>
                  <source srcset="{{ asset('mobile/images/avatar/17.webp') }}" type="image/webp">
                  <img class="avt-img" src="{{ asset('mobile/images/avatar/17.jpg') }}" alt="">
                </picture>
                <div class="txt-user">
                  <h5>5.1 <span>ETH</span></h5>
                  <p>Tito_Calab <i class="ri-checkbox-circle-fill"></i> </p>
                </div>
              </a>
              <div class="other-option">
                <button type="button" class="btn btn-box-check">
                  <input type="checkbox">
                  <div class="icon-box">
                    <i class="ri-add-fill"></i>
                  </div>
                </button>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </section>
  </div>
  <!-- ===================================
    START THE BOTTOM NAVIGATION
  ==================================== -->
  <footer class="un-bottom-navigation filter-blur">
    <div class="em_body_navigation border-0 -active-links">
      <div class="item_link">
        <a href="homepage.html" class="btn btn_navLink" aria-label="btnNavigation">
          <div class="icon_current">
            <i class="ri-home-5-line"></i>
          </div>
          <div class="icon_active">
            <i class="ri-home-5-fill"></i>
          </div>
        </a>
      </div>
      <div class="item_link">
        <a href="page-search-random.html" class="btn btn_navLink" aria-label="btnNavigation">
          <div class="icon_current">
            <i class="ri-search-2-line"></i>
          </div>
          <div class="icon_active">
            <i class="ri-search-2-fill"></i>
          </div>
        </a>
      </div>
      <div class="item_link">
        <button type="button" name="uploadItem" aria-label="uploadItem" class="btn btn_navLink without_active"
          data-bs-toggle="modal" data-bs-target="#mdllUploadItem" aria-label="btnNavigation">
          <div class="btn btnCircle_default">
            <i class="ri-add-line"></i>
          </div>
        </button>
      </div>
      <div class="item_link">
        <a href="page-favourit-random.html" class="btn btn_navLink" aria-label="btnNavigation">
          <div class="icon_current">
            <i class="ri-heart-3-line"></i>
          </div>
          <div class="icon_active">
            <i class="ri-heart-3-fill"></i>
          </div>
        </a>
      </div>
      <div class="item_link">
        <a href="page-account.html" class="btn btn_navLink" aria-label="btnNavigation">
          <div class="icon_current">
            <i class="ri-user-4-line"></i>
          </div>
          <div class="icon_active">
            <i class="ri-user-4-fill"></i>
          </div>
        </a>
      </div>
    </div>
  </footer>
@endsection

