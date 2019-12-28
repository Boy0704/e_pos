<div class="contact-area">

    <div class="container"> 

      <!-- Start Contact Locaton Google Map -->

      <!-- /End Contact Locaton Google Map --> 

      <!-- Start Contact Information -->

      <div class="row section-padding"> 

        <!-- Contact Info -->

        <div class="col-md-4 col-sm-5">

          <div class="right-side-contact-info">

            <div class="contact-info-title border-spacing">

              <h2>My Profil Info</h2>

            </div>

            <div class="contact-info-details">

              <ul>

                <li>

                  <div class="contac-info-single">

                    <div class="contact-info-single-title"> <i class=" icon_pin_alt"></i>

                      <h3>Alamat</h3>

                    </div>

                    <div class="contact-info-single-content">

                      <p><?php echo $profil->alamat; ?></p>

                    </div>

                  </div>

                </li>

                <li>

                  <div class="contac-info-single">

                    <div class="contact-info-single-title"> <i class="icon_mobile"></i>

                      <h3>Phone</h3>

                    </div>

                    <div class="contact-info-single-content">

                      <p><?php echo $this->session->userdata('no_hp'); ?></p>

                      <p>(+88) 017-82185711</p>

                    </div>

                  </div>

                </li>

                <li>

                  <div class="contac-info-single">

                    <div class="contact-info-single-title"> <i class="icon_mail_alt "></i>

                      <h3>Email</h3>

                    </div>

                    <div class="contact-info-single-content">

                      <p><?php echo $this->session->userdata('email'); ?></p>

                    </div>

                  </div>

                </li>

              </ul>

            </div>

          </div>

        </div>

        <!-- Contact Form -->

        <div class="col-md-8 col-sm-7">

          <div class="left-side-contact-form">

            <div class="contact-info-title border-spacing">

              <h2></h2>

            </div>

            <div class="">

              <form class="contact-form" id="form_contact" action="web/update_profil" method="POST">

                <div class="row">

                  <div class="col-md-4">
                     <input type="hidden" name="id_pelanggan" value="<?php echo $this->session->userdata('id_pelanggan'); ?>">
                    <div class="form-group">

                      <div class="box">

                        <input id="name" class="form-control" type="text" name="nama_pelanggan" required />

                        <label>Nama Lengkap *</label>

                      </div>

                    </div>

                  </div>

                  <div class="col-md-4">

                    <div class="form-group">

                      <div class="box">

                        <input id="email" class="form-control" type="text" name="email" required />

                        <label>Email *</label>

                      </div>

                    </div>

                  </div>

                  <div class="col-md-4">

                    <div class="form-group">

                      <div class="box">

                        <input id="mysubject"  class="form-control" type="text" name="no_hp" required />

                        <label>Handphone *</label>

                      </div>

                    </div>

                  </div>
                  <div class="col-md-4">

                    <div class="form-group">

                      <div class="box">

                        <input id="mysubject"  class="form-control" type="text" name="rt" required />

                        <label>RT *</label>

                      </div>

                    </div>

                  </div>

                  <div class="col-md-4">

                    <div class="form-group">

                      <div class="box">

                        <input id="mysubject"  class="form-control" type="text" name="rw" required />

                        <label>RW *</label>

                      </div>

                    </div>

                  </div>

                  <div class="col-md-4">

                    <div class="form-group">

                      <div class="box">

                        <input id="mysubject"  class="form-control" type="text" name="no_rumah" required />

                        <label>Nomor Rumah *</label>

                      </div>

                    </div>

                  </div>

                </div>

                <div class="form-group">

                  <div class="box">

                    <textarea id="mymessage" class="form-control" rows="10" name="alamat" required></textarea>

                    <label>Alamat Lengkap</label>

                  </div>

                </div>

                <div class="text-left">

                  <input id="submit_message"  class="btn btn-primary" type="submit" value="Simpan"/>

                  <span class="loading"><i class="fa-pulse"></i></span>

                  <div class="clearfix"></div>

                  <div id="reply_message"></div>

                </div>

              </form>

            </div>

          </div>

        </div>

      </div>

      <!-- /End Contact Information --> 

    </div>

  </div>