<style>
#fbic {
    color: #3B579D;
}
#twic {
    color: #2CAAE1;
}

#phic {
    color: #5DE653;
}
#heart {
    color: red;
}
.twitter-share-button {
    color: red;
}

</style>
<?php if(isset($is_social_like) && $is_social_like != '' ) { ?>
<a id="heart-<?php echo $ml_num ;?>" onclick="switchlike('heart-<?php echo $ml_num ;?>','likelist');" style="color: red;" class="uk-icon-heart-o uk-icon-medium" href="#"></a>
<?php } ?>
<a href="" id="fbic" class="uk-icon-medium uk-icon-hover uk-icon-facebook-square"></a>
<a  href="http://twitter.com/intent/tweet?text=<?php echo $ShortPageTitle." ".$community." ".$municipality."&hashtags=";?>Property4Sale<?php echo  "&url=https://gta2sell.com".$_SERVER['REQUEST_URI'] ; ?>" id="twic" class="uk-icon-medium uk-icon-hover uk-icon-twitter-square"></a>
<a href="" id="phic" class="uk-icon-medium uk-icon-hover uk-icon-phone-square"></a>
<a href="/contact" id="phem" class="uk-icon-medium uk-icon-hover uk-icon-envelope-square"></a>
