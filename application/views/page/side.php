<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="image/user/<?php echo $this->session->userdata('foto'); ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $this->session->userdata('nama'); ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        
        <?php if ($this->session->userdata('level') == 'admin'){ ?>
        <li><a href="app"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        <li class="treeview">
          <a href="#">
              <i class="fa fa-list"></i>
              <span>Master Produk</span>
              <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
              <li><a href="subkategori"><i class="fa fa-angle-double-right"></i> Produk List</a></li>
              <li><a href="kategori"><i class="fa fa-angle-double-right"></i> Kategori Produk</a></li>
              <!-- <li><a href="stok"><i class="fa fa-angle-double-right"></i> Stok</a></li> -->
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
              <i class="fa fa-odnoklassniki"></i>
              <span>Purchase Order</span>
              <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
              <li><a href="po_master"><i class="fa fa-angle-double-right"></i> Master PO</a></li>
              <!-- <li><a href="pembelian"><i class="fa fa-angle-double-right"></i> Pembelian</a></li> -->
          </ul>
        </li>
        <li><a href="app/transaksi"><i class="fa fa-cart-plus"></i> <span>Transaksi Penjualan</span></a></li>
        <li><a href="app/list_transaksi"><i class="fa fa-keyboard-o"></i> <span>List Transaksi</span></a></li>
        <li><a href="produk_display"><i class="fa fa-cube"></i> <span>Produk Display</span></a></li>
        
        <li><a href="suplier"><i class="fa fa-bank"></i> <span>SUPLIER</span></a></li>
        <li><a href="return_new"><i class="fa fa-external-link-square"></i> <span>Return List</span></a></li>
        <li><a href="kas_awal"><i class="fa fa-download"></i> <span>Kas Awal</span></a></li>
        <li class="treeview">
          <a href="#">
              <i class="fa fa-print"></i>
              <span>Laporan</span>
              <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
              <li><a href="laporan/penjualan"><i class="fa fa-angle-double-right"></i> Penjualan</a></li>
              <li><a href="laporan/pembelian"><i class="fa fa-angle-double-right"></i> Pembelian</a></li>
              <li><a href="laporan/pembayaran"><i class="fa fa-angle-double-right"></i> Pembayaran</a></li>
              <li><a href="laporan/barang"><i class="fa fa-angle-double-right"></i> Barang</a></li>
          </ul>
        </li>
        <li><a href="owner"><i class="fa fa-share-square"></i> <span>Setting</span></a></li>
        <li><a href="pengaturan_aplikasi"><i class="fa fa-share-square"></i> <span>Setting Aplikasi</span></a></li>
        <li><a href="app/log_user"><i class="fa fa-history"></i> <span>Log User</span></a></li>
        <li><a href="a_user"><i class="fa fa-users"></i> <span>Master User</span></a></li>

        <?php } elseif ($this->session->userdata('level') == 'kasir') {?>

        <li><a href="app"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        
        <li><a href="app/transaksi"><i class="fa fa-cart-plus"></i> <span>Transaksi Penjualan</span></a></li>
        <li><a href="app/list_transaksi"><i class="fa fa-keyboard-o"></i> <span>List Transaksi</span></a></li>
        <li><a href="produk_display"><i class="fa fa-cube"></i> <span>Produk Display</span></a></li>
        <li><a href="kas_awal"><i class="fa fa-download"></i> <span>Kas Awal</span></a></li>
        

        <?php } ?>
        
        

        <li class="header">LABELS</li>
        <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Faqs</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Tentang Aplikasi</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>