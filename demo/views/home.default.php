<?php includeView($controller, 'head'); ?>
<body data-url-prefix="<?php echo $_SPRIT['URL_PREFIX']; ?>" data-page-url="home">
<?php includeView($controller, 'header'); ?>
<div class="divFullPageHeader">
    <div class="divTabsContainer z-depth-1">
    </div>
</div>
<section style="margin-top:20px;">
    <div class="row">
        <div class="col s12 m4 l4">
            <div class="info-box blue darken-1 hover-expand-effect">
                <div class="icon">
                    <i class="material-icons"><i class="ion-briefcase"></i></i>
                </div>
                <div class="content">
                    <div class="text white-text">FİRMA</div>
                    <div class="number count-to white-text" data-from="0" data-to="125" data-speed="1000" data-fresh-interval="20">
                        125
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m4 l4">
            <div class="info-box green darken-1 hover-expand-effect">
                <div class="icon">
                    <i class="material-icons"><i class="ion-ribbon-b"></i></i>
                </div>
                <div class="content">
                    <div class="text white-text">UYGULAMA</div>
                    <div class="number count-to white-text" data-from="0" data-to="125" data-speed="1000" data-fresh-interval="20">
                        125
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m4 l4">
            <div class="info-box amber hover-expand-effect">
                <div class="icon">
                    <i class="material-icons"><i class="ion-clipboard"></i></i>
                </div>
                <div class="content">
                    <div class="text white-text">DENETİM</div>
                    <div class="number count-to white-text" data-from="0" data-to="125" data-speed="1000" data-fresh-interval="20">
                        125
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="divHiddenElements">
    <div id="divCacheClassListTemplate">
        <div class="col s12">
            <label class="checkbox2 left-align" for="inputCacheClass__CLASS_NAME__">
                <input class="inputCacheClass inputCacheClass__CLASS_NAME__" id="inputCacheClass__CLASS_NAME__"
                       name="inputCacheClass__CLASS_NAME__" checked="checked" value="__CLASS_NAME__" type="checkbox">
                <span class="outer">
                            <span class="inner"></span>
                        </span>
                <span>__CLASS_NAME__</span>
            </label>
        </div>
    </div>
</div>
<script src="assets/js/global.js"></script>
<script src="assets/js/home.js"></script>
</body>
</html>