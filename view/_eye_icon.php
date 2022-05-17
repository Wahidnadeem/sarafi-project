<div class="col-md-12">
    <h2 class="lalezar text-muted"> <?php echo $header_title; ?>
        <?php if($SHOW_EYE == "SHOW"){  ?>
            <i onclick="togg_icon('hide')" class="far eye_icon pr fa-eye ms-2 h5 pointer togg"></i>
            <i onclick="togg_icon('show')" class="far eye_icon pr fa-eye-slash ms-2 h5 priv pointer togg"></i>
        <?php }else { ?>
            <i onclick="togg_icon('hide')" class="far eye_icon pr fa-eye ms-2 h5 pointer priv togg"></i>
            <i onclick="togg_icon('show')" class="far eye_icon pr fa-eye-slash ms-2 h5 pointer togg"></i>
        <?php }?>
    </h2>
</div>