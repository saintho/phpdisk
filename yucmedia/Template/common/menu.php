<?php
$act = isset($_GET['act']) ? $_GET['act'] : 'index';
?>
<script type="text/javascript">
    $(function () {
        var id = "<?php echo $act;?>";
        $("#menu a").hover(function () {
            $("#menu a").removeClass('bg_p2').removeClass('bg_p1').addClass('bg_p3');
            $(this).removeClass('bg_p3').addClass('bg_p2');
            $(this).prev("a").removeClass('bg_p3').addClass('bg_p1');
        }, function () {
            $(this).removeClass('bg_p2').addClass('bg_p3');
            $(this).prev("a").removeClass('bg_p1').addClass('bg_p3');

            $("#" + id).removeClass('bg_p3').addClass('bg_p2');
            $("#" + id).prev('a').removeClass('bg_p2').addClass('bg_p1');
        })


        $("#" + id).removeClass('bg_p3').addClass('bg_p2');
        $("#" + id).prev('a').addClass('bg_p1');
    })
</script>
