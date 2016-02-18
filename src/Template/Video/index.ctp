<?php 

echo $this->Html->css('Video.video');

?>

<div class="page-title row">
    <?php echo $this->element('page_title', array(
        'title'=>'Video',
        'pageArray'=>array('Filter Test 1'),
        'linkArray'=>array('Video'),
        'link'=>'/video/',
        'class'=>'pull-left'
    )); ?>
    <div class="input-group input-group-min pull-right col-xs-6 col-md-3 col-xl-2">
        <span class="input-group-addon"><i class="md-search"></i></span>
        <input type="text" class="form-control form-control-min search" placeholder="Search" id="search">
    </div> 
    <div class="pull-right">
        <a href="/GettingStarted" class="btn btn-link">Getting Started</a>
    </div>
</div>
<div class="row hidden-xs hidden-sm">
    <div id="filters-box" class="padding-none">
        <div id="filter-test1" class="active"><span><i class="md-home filter-icon"></i>Filter Test 1</span></div>
        <div id="filter-test2"><span><i class="md-local-hospital filter-icon"></i>Filter Test 2</span></div>
        <div id="filter-test3"><span><i class="md-group-work filter-icon"></i>Filter Test 3</span></div>
        
    </div>
    <div id="videos-box" class="row"></div>
</div>
<div class="row hidden-md hidden-lg hidden-xl">
    <div class="col-xs-12 padding-none">
        <div class="btn-group btn-block">
            <div id="small-menu" class="btn btn-primary btn-block" role="menu" data-toggle="dropdown" aria-expanded="false">Filter Test 1<span class="caret" style="margin-left: 10px;"></span></div>
            <ul id="small-dropdown-menu" class="dropdown-menu padding-none"></ul>
        </div>
    </div>
    <div class="small-videos-box-spacer row"></div>
    <div id="small-videos-box"></div>
</div>
<script>
    /* 
     
     To add a new video, just add a new object.

     filter: Filter Test 1, Filter Test 2, Filter Test 3
     title: video title
     thumbnail: local img or video thumbnail from Vimeo URL
     url: url of the Vimeo video 
    
    */
    var videoArray = [
        {
            filter: "Filter Test 1",
            title: "Escalator Zoom",
            thumbnail: "/video/img/thumbnails/Stock.jpg",
            url: "//player.vimeo.com/video/1846726"
        },
        {
            filter: "Filter Test 1",
            title: "Zoom trailer",
            thumbnail: "/video/img/thumbnails/Stock.jpg",
            url: "//player.vimeo.com/video/5173307"
        },
        {
            filter: "Filter Test 2",
            title: "Creative Sweat",
            thumbnail: "/video/img/thumbnails/1120170.jpg",
            url: "//player.vimeo.com/video/5173307"
        },           
    ];
    
    // Runs when the page is loaded. Presents our videos.
    $(document).ready(function() {
        for (var i = 0, len = videoArray.length; i < len; i++) {
            if (videoArray[i]['filter'] === 'Filter Test 1') {
                $('<div class="single-video-box col-lg-4 col-md-6"><img class="col-md-12 single-video padding-none" id="'+videoArray[i]['url']+'" data-title="'+videoArray[i]['title']+'" data-description="'+videoArray[i]['description']+'" src="'+videoArray[i]['thumbnail']+'"><span class="video-title">'+videoArray[i]['title']+'</span></div>').appendTo($("#videos-box"));
                $('<div class="small-single-video-box col-xs-12"><img class="col-xs-12 small-single-video padding-none" id="'+videoArray[i]['url']+'" data-title="'+videoArray[i]['title']+'" data-description="'+videoArray[i]['description']+'" src="'+videoArray[i]['thumbnail']+'"><span class="video-title">'+videoArray[i]['title']+'</span></div>').appendTo($("#small-videos-box"));
            }
        }
    });
    
    // calls a modal with information on the selected contact
    $(document).on("click", ".single-video, .small-single-video", function () {
        var videoID = $(this).attr('id');
        $('<div class="modal" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-body" style="background:black"><div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="'+videoID+'" allowfullscreen></iframe></div></div></div></div></div>').modal('show');
    });
    
    // The following function prints our small menu. Done in JavaScript to reduce redundant categories and provide future flexibility.
    $(document).on("click", "#small-menu", function() {
        var currentlySelected = $("#small-menu").text().trim();
        var menu = document.getElementById("small-dropdown-menu");
        var filterArray = [
            {
                id: "small-filter-test1",
                text: "Filter Test 1"
            },
            {
                id: "small-filter-test2",
                text: "Filter Test 2"
            },
            {
                id: "small-filter-test3",
                text: "Filter Test 3"
            },
        ];
        
        while (menu.firstChild) {
            menu.removeChild(menu.firstChild);
        }
        
        for (var i = 0, len = filterArray.length; i < len; i++) {
            if (filterArray[i]['text'] !== currentlySelected) {
                $('<li id="'+filterArray[i]['id']+'"><div class="pull-center"><span>'+filterArray[i]['text']+'</span></div></li>').appendTo("#small-dropdown-menu");
            }
        }
    });
    
    // This function is called when we click on any filter. It sets the text of the page and filters our videos.
    $(document).on("click", "[id^='filter-'], [id^='small-filter-']", function() {
        var filterData = document.getElementById(this.id);
        var filterID = filterData.getAttribute('id');
        var largeFilterID = filterID.replace('small-', '');
        var title = $(this).text();
        var filter = $(this).text().trim();
        
        $('[id^="filter-"]').removeAttr('class'); 
        $('#'+largeFilterID).addClass('active');
        $('#bc0').text(title);
        $('#small-menu').html(title+' <span class="caret" style="margin-left:10px;"></span>');
    
        // Reset the search box to nothing, since filter overrides a search.
        document.getElementById("search").value = '';
         
        // The following bit of code stores the id of the boxes that hold the videos and remove them as long as there is a video to remove.
        // This is so that the filter will then only show videos that need to be seen.
        var largeVideos = document.getElementById("videos-box");
        var smallVideos = document.getElementById("small-videos-box"); 
        
        while (largeVideos.firstChild) {
            largeVideos.removeChild(largeVideos.firstChild);
            smallVideos.removeChild(smallVideos.firstChild);
        }
        
        // Prints the videos that have the same filter as the filters we clicked.
        for (var i = 0, len = videoArray.length; i < len; i++) {
            if (videoArray[i]['filter'] === filter) {
                $('<div class="single-video-box col-lg-4 col-md-6"><img class="col-md-12 single-video padding-none" id="'+videoArray[i]['url']+'" data-title="'+videoArray[i]['title']+'" data-description="'+videoArray[i]['description']+'" src="'+videoArray[i]['thumbnail']+'"><span class="video-title">'+videoArray[i]['title']+'</span></div>').appendTo($("#videos-box"));
                $('<div class="small-single-video-box col-xs-12"><img class="col-xs-12 small-single-video padding-none" id="'+videoArray[i]['url']+'" data-title="'+videoArray[i]['title']+'" data-description="'+videoArray[i]['description']+'" src="'+videoArray[i]['thumbnail']+'"><span class="video-title">'+videoArray[i]['title']+'</span></div>').appendTo($("#small-videos-box"));
            }
        }
    });
    
    // A quick regex search that only displays videos containing the search terms.
    $(document).on("paste, keyup", "#search", function() {
        var rowLarge = $('#videos-box .single-video-box');
        var rowSmall = $('#small-videos-box .small-single-video-box');

        var val = '^(?=.*\\b' + $.trim($(this).val()).split(/\s+/).join('\\b)(?=.*\\b') + ').*$';
        var reg = RegExp(val, 'i');
        var text;
      
        // If screen is greater than or equal to 992
        rowLarge.show().filter(function() {
            text = $(this).text().replace(/\s+/g, ' ');
            return !reg.test(text); 
       }).hide();
       
       rowSmall.show().filter(function() {
            text = $(this).text().replace(/\s+/g, ' ');
            return !reg.test(text); 
       }).hide();
    });
   
</script>