<!-- /End Banner Area --> 
<!-- Start Products Row -->
<div class="products-row-area section-padding">

  <div class="container">

    <div class="row">

      <div class="col-md-12 col-sm-12"> 

        <!-- Section Title  -->

        <div class="section-title">

          <h2>Home Care</h2>

        </div>

      </div>

    </div>

    <div class="row"> 

      <!-- Products List  -->

      <div class="product-list"> 

        <!-- Single Product Start -->
<?php foreach ($homecare as $key => $value) { ?>
         <div class="col-lg-12">

          <div class="single-product">

            <div class="singl-product-top"> <a href="#"> <img src="image/produk_mobile/<?= $value->foto?>" alt="" class="front-image"> <img src="image/produk_mobile/<?= $value->foto?>" alt="" class="back-image"> <span class="single-pro-quick-view"> <span class="single-pro-quick-table"> <span class="single-pro-quick-table-cell"> <i class="fa fa-search"></i> </span> </span> </span> </a>

              <div class="product-action">

                <ul>

                  <li><a href="#"><i class="icon_gift_alt"></i></a></li>

                  <li><a href="#"><i class="icon_heart_alt"></i></a></li>

                  <li><a href="#"><i class="icon_refresh"></i></a></li>

                  <li><a href="#"><i class="icon_cart_alt"></i></a></li>

                </ul>

              </div>

              <div class="single-product-label label-on-sale">On Sale</div>

            </div>

            <div class="single-product-bottom">

              <h2 class="product-title"><a href="#"><?= $value->nama_produk ?></a></h2>

              <p class="product-price">Rp.<?= number_format($value->harga,2,',','.') ?> <span class="old-price"></span></p>

            </div>

          </div>

        </div>
<?php } ?>
      </div>

    </div>

  </div>

</div>

<!-- /End Products Row --> 

<!-- Start Products Row -->

<div class="products-row-area ">

  <div class="container">

    <div class="row">

      <div class="col-md-12 col-sm-12"> 

        <!-- Section Title -->

        <div class="section-title">

          <h2>Rokok</h2>

        </div>

      </div>

    </div>

    <div class="row"> 

      <!-- Products List  -->

      <div class="product-list"> 

        <!-- Single Product Start -->
<?php foreach ($rokok as $key => $value) { ?>


        <div class="col-lg-12">

          <div class="single-product">

            <div class="singl-product-top"> <a href="#"> <img src="image/produk_mobile/<?= $value->foto?>" alt="" class="front-image"> <img src="image/produk_mobile/<?= $value->foto?>" alt="" class="back-image"> <span class="single-pro-quick-view"> <span class="single-pro-quick-table"> <span class="single-pro-quick-table-cell"> <i class="fa fa-search"></i> </span> </span> </span> </a>

              <div class="product-action">

                <ul>

                  <li><a href="#"><i class="icon_gift_alt"></i></a></li>

                  <li><a href="#"><i class="icon_heart_alt"></i></a></li>

                  <li><a href="#"><i class="icon_refresh"></i></a></li>

                  <li><a href="#"><i class="icon_cart_alt"></i></a></li>

                </ul>

              </div>

              <div class="single-product-label label-on-sale">On Sale</div>

            </div>

            <div class="single-product-bottom">

              <h2 class="product-title"><a href="#"><?= $value->nama_produk ?></a></h2>

              <p class="product-price">Rp.<?= number_format($value->harga,2,',','.') ?> <span class="old-price"></span></p>

            </div>

          </div>

        </div>

<?php } ?>

      </div>

    </div>

  </div>

</div>

<!-- /End Products Row --> 

<!-- Start Banner Area -->

<div class="banner-area section-padding">

<!--   <div class="container">

    <div class="row">

      <div class="col-md-6 col-sm-6">  -->

        <!-- Banner Image -->

<!--         <div class="banner"> <a href="#"> <img src="front/img/banner/3.jpg" alt=""> </a> </div>

      </div>

      <div class="col-md-6 col-sm-6"> 
 -->
        <!-- Banner Image -->
<!-- 
        <div class="banner"> <a href="#"> <img src="front/img/banner/4.jpg" alt=""> </a> </div>

      </div>

    </div>

  </div>
 -->
</div>

<!-- /End Banner Area --> 

<!-- Start Products Row -->

<div class="products-row-area">

  <div class="container">

    <div class="row">

      <div class="col-md-12 col-sm-12"> 

        <!-- Section Title -->

        <div class="section-title">

          <h2>Kelontong</h2>

        </div>

      </div>

    </div>

    <div class="row"> 

      <!-- Products List  -->
      <?php foreach ($kelontong as $key => $value) { ?>


        <div class="col-lg-12">

          <div class="single-product">

            <div class="singl-product-top"> <a href="#"> <img src="image/produk_mobile/<?= $value->foto?>" alt="" class="front-image"> <img src="image/produk_mobile/<?= $value->foto?>" alt="" class="back-image"> <span class="single-pro-quick-view"> <span class="single-pro-quick-table"> <span class="single-pro-quick-table-cell"> <i class="fa fa-search"></i> </span> </span> </span> </a>

              <div class="product-action">

                <ul>

                  <li><a href="#"><i class="icon_gift_alt"></i></a></li>

                  <li><a href="#"><i class="icon_heart_alt"></i></a></li>

                  <li><a href="#"><i class="icon_refresh"></i></a></li>

                  <li><a href="#"><i class="icon_cart_alt"></i></a></li>

                </ul>

              </div>

              <div class="single-product-label label-on-sale">On Sale</div>

            </div>

            <div class="single-product-bottom">

              <h2 class="product-title"><a href="#"><?= $value->nama_produk ?></a></h2>

              <p class="product-price">Rp.<?= number_format($value->harga,2,',','.') ?> <span class="old-price"></span></p>

            </div>

          </div>

        </div>

<?php } ?>
      <div class="product-list"> 

       

      </div>

    </div>

  </div>

</div>

<!-- /End Products Row --> 

<!-- Start Products Row -->

<div class="products-row-area section-padding">


</div>

<!-- /End Products Row --> 

<!-- Start Services Area -->


<!-- /End Services Area --> 

<!-- Start Blogs Area -->



          <!-- /End Blogs Area --> 

          <!-- Start Brand Logos Area -->

          

          <!-- /End Brand Logos Area --> 

          <!-- Start Main Footer Area -->   