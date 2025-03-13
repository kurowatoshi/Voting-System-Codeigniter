<?php if ($pilih < 1): ?>
      <?php if ($passdefault): ?>
        <div class="col-sm-12">
          <div class="tengah">
            <div class="col-sm-5">
              <div class="box box-danger box-solid">
                <div class="box-header">
                  <h4 class="box-title"><i class="fa fa-lock"></i> Change Password</h4>
                </div>
                <div class="box-body">
                  <p class="text-center text-muted">Please change the password to continue</p>
                  <form id="formUbahPasswd">
                    <div class="form-group">
                      <label for="PasswordLama">Old Password :</label>
                      <input type="password" name="passwdlama" class="form-control" placeholder="Enter Old Password">
                    </div>
                    <div class="form-group">
                      <label for="PasswordBaru">New Password :</label>
                      <input type="password" name="passwdbaru" class="form-control" placeholder="Enter New Password">
                    </div>
                    <button class="btn btn-danger btn-flat">Save</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php else: ?>
        <div class="col-sm-12">
          <div class="box" style="background-color: transparent !important; border: none !important;">
            <div class="box-body">
              <div style="margin-top: 20px !important; margin-bottom: -20px !important; font-weight: 600;">
                <h1 class="text-center no-margin"><?=$voting->voting_name?></h1> <!-- Changed 'nama_voting' to 'voting_name' -->
                <h4 class="text-muted text-center">*Please choose a candidate to continue</h4>
              </div>
              <hr>
              <div class="tengah">
                <?php foreach ($kandidat as $k): ?>
                <div class="col-sm-4">
                  <div class="box" style="border: none !important;">
                    <div class="box-body box-profile">
                      <img src="<?=base_url('assets/img/kandidat/'.$k->photo);?>" alt="" class="profile-user-img img-kandidat img-responsive img-circle"> <!-- Changed 'foto' to 'photo' -->
                      <h3 class="profile-username text-center"><?=$k->candidate_name?></h3> <!-- Changed 'nama_kandidat' to 'candidate_name' -->
                      <p class="text-center text-muted"><?=$k->description?></p> <!-- Changed 'keterangan' to 'description' -->
                      <button class="btn btn-danger btn-flat btn-block pilih" data="<?=$k->id_candidate?>" data-voting="<?=$voting->id_voting?>" data-nama="<?=$k->candidate_name?>">Vote</button> <!-- Changed 'id_kandidat' to 'id_candidate' and 'nama_kandidat' to 'candidate_name' -->
                    </div>
                  </div>
                </div>
                <?php endforeach ?>
              </div>
            </div>
          </div>
        </div>
      <?php endif ?>
    <?php else: ?>
        <div class="col-sm-12">
          <div class="box box-solid vh-100">
            <div class="box-body">
              <h2 class="text-center">Thank You For Your Participation!</h2>
              <h4 class="text-center">We hope to see you again.</h4>
              <div class="tengah">
                <button class="btn btn-danger btn-flat logout text-center" style="">LOGOUT NOW</button>
              </div>
            </div>
          </div>
        </div>
    <?php endif ?>

      <script>
        $('#formUbahPasswd').on('submit', function(e){
          e.preventDefault();
          var id = <?=$this->session->id?>;
          var passLama = $('[name="passwdlama"]').val(), passBaru = $('[name="passwdbaru"]').val();
          if (passLama != '' || passBaru != '') {
            $.ajax({
              type: 'POST',
              url: '<?=base_url("user/set_pass_id/")?>'+id,
              data: {passwdLama: passLama, passwdBaru: passBaru},
              success: function(data){
                if (data == 1) {
                  $('#formUbahPasswd').trigger('reset');
                  Swal.fire('Success', 'You will be redirected in 5 seconds', 'success');
                  setTimeout(function(){
                    window.location.reload()
                  }, 5000);
                }
                else{
                  $('#formUbahPasswd').trigger('reset');
                  Swal.fire('Failed', 'Wrong old password!', 'error');
                }
              }
            })
          }
          else{
            Swal.fire('Failed', 'Form must be filled!', 'error');
            return false;
          }
        })
        //pilih
        $('.pilih').on('click', function(e){
          e.preventDefault();
          var id = $(this).attr('data');
          var voting = $(this).attr('data-voting');
          var nama = $(this).attr('data-nama');
          Swal.fire({
            type: 'question',
            title: 'Select '+nama,
            text: 'Are you sure you will vote for the candidate ?',
            showCancelButton: true,
            confirmButtonText: 'Select'
          }).then((result) => {
            if (result.value) {
              //aksi
              $.ajax({
                type: 'POST',
                url: '<?=base_url("user/pilih/")?>'+voting+'/'+id,
                success: function(data){
                  if (data == 1) {
                    Swal.fire({
                      type: 'success',
                      title: 'Success',
                      text: 'You have chosen '+nama,
                    }).then((result) => {
                      if (result.value) {
                        window.location.reload()
                      }
                    })
                  }
                }
              })
            }
          })
        })
        //logout
        $('.logout').on('click', function(e){
          e.preventDefault()
          window.location.assign('<?=base_url("user/logout")?>')
        })
      </script>

    <?php if ($pilih > 0): ?>
      <script>
        setTimeout(function(){
          window.location.assign('<?=base_url("user/logout")?>');
        }, 120000)
      </script>
    <?php endif ?>
