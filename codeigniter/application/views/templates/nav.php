
<div class="container">
    <div class="row" id="header-row">
        <div class="col-sm-8">
            <span id="project-name"><strong>PERFORMANCE MONITORING SYSTEM</strong></span>
        </div>

        <div class="col-sm-4 text-right">
            <span><img id="dynaslope-logo" src="/images/dynaslope-logo.png" /></span>
            <span class="nav-general-text text-center">
                IMPLEMENTED 
                <span>AND FUNDED BY</span>
            </span>
            <span><img id="dost-phivolcs-logo" src="/images/dost-phivolcs-logo.png" /></span>
        </div>
    </div>
</div>

<div class="nav-row" id="navigation">
    <ul>
        <span id="logo" class="col-sm-4" hidden>PMS - DYNASLOPE</span>
        <span id="links">
        <?php 
            $uri_array = $_SERVER["REQUEST_URI"];
            $uri_array = explode("/", $uri_array);
            $tab = $uri_array[1];

            /**
             * 
             *  ADD LINKS HERE FOR THE NAVBAR
             *  FOLLOW THE FORMAT OF ARRAY
             * 
             */
            $links = array(
                array('link_uri' => '', 'link_name' => 'DASHBOARD'),
                array('link_uri' => 'input', 'link_name' => 'INPUT PAGE'),
                array('link_uri' => 'faq', 'link_name' => 'FAQ')
            );

            foreach ($links as $link) 
            {
                if( $link['link_uri'] == $tab ) echo '<li class="active-tab-nav">';
                else echo "<li>";
                echo '<a href="' . base_url() . $link["link_uri"] . '">' . $link["link_name"] . '</a></li>';
            }
        ?>
        </span>
    </ul>
</div>

<script>
$(document).ready( function() {
    (function($) {
        "use strict";

        var $navbar = $("#navigation"),
            y_pos = $navbar.offset().top;
            //height = $navbar.height();

        $(document).scroll(function() {
            var scrollTop = $(this).scrollTop();

            if (scrollTop > y_pos) {
                $navbar.addClass("sticky");
                $navbar.find("#links").addClass("col-sm-8");
                $navbar.find("#logo").show();
                $("#page-wrapper").addClass("sticky-wrapper");
            } else if (scrollTop <= y_pos) {
                $navbar.removeClass("sticky");
                $navbar.find("#links").removeClass("col-sm-8").clearQueue();
                $navbar.find("#logo").hide();
                $("#page-wrapper").removeClass("sticky-wrapper");
            }
        });
    })(jQuery, undefined);
});
</script>