<div class="row justify-content-center">

    <form  action='password_reset.php' method="POST">
      <div  style="width: 340px; border: 1px solid #d8dee2; border-radius: 5px; padding: 20px; background: #fff;">
        <div class="form-group">
          <label for="exampleInputEmail1" style="font-size: 15px; margin-bottom: 20px;">
              Введите ваш e-mail адрес и мы, вышлем вам новый пароль на ваш e-mail.
          </label>
          <input id="login" value="<?php echo @$_POST['email'];?>"  type="email" name="email" style="font-size: 15px;" class="form-control <?php if($isErrorShow) echo "is-invalid";?>" aria-describedby="emailHelp" placeholder="Enter email">
        </div>

        <div class="control-group">
          <div class="controls">
            <button id="btnReset" name="do_reset" type="submit" class="btn btn-block btn-success mt-4" style="cursor: pointer; color: #fff; font-size: 15px;">Сбросить пароль</button>
          </div>
        </div>
      </div>
    </form>

</div>
