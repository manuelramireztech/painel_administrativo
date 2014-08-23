<div class="clearfix">
    <strong>Inform o código corretamente *:</strong> 
</div>
<div class="clearfix">
    <input type="text" required name="code" size="12" maxlength="16" />
    <a tabindex="-1" style="border-style: none;" href="#" title="Atualizar código" onclick="document.getElementById('siimage').src = '<?php echo base_url(); ?>pages/captcha?' + Math.random();
            this.blur();
            return false;">
        <img width="20" src="<?php echo base_url(); ?>resources/images/refresh.png" alt="Atualizar" title="Atualizar Imagem" onclick="this.blur()" align="bottom" border="0">
    </a>
</div>
<div class="clearfix">
    <img id="siimage" style="border: 1px solid #000;" src="<?php echo base_url(); ?>pages/captcha?sid=<?php echo md5(uniqid()) ?>" alt="CAPTCHA Image" align="left">
</div>