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
        <!-- <li><a href="Kategori"><i class="fa fa-list"></i> <span>Master Kategori</span></a></li>
        <li><a href="calon"><i class="fa fa-odnoklassniki"></i> <span>Master Calon</span></a></li>
        <li><a href="pemilih"><i class="fa fa-odnoklassniki"></i> <span>Master Pemilih</span></a></li> -->
        <li><a href="suplier"><i class="fa fa-bank"></i> <span>SUPLIER</span></a></li>
        <li><a href="Return"><i class="fa fa-external-link-square"></i> <span>Return List</span></a></li>
        <li><a href="owner"><i class="fa fa-share-square"></i> <span>Setting</span></a></li>
        <li><a href="a_user"><i class="fa fa-users"></i> <span>Master User</span></a></li>

        <li class="header">LABELS</li>
        <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Faqs</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Tentang Aplikasi</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>