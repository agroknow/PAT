<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if IE 9]>    <html class="no-js ie9" lang="en"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="generator" content="" />
        <title><?php echo h($exhibit->title); ?></title>

        <!--[if (gte IE 6)&(lte IE 8)]>
        <script type="text/javascript" src="<?php echo uri('plugins/ExhibitBuilder/views/public/exhibits/'); ?>javascript/selectivizr-min.js"></script>
        <![endif]-->

        <link rel="stylesheet" href="<?php echo uri('plugins/ExhibitBuilder/views/public/exhibits/'); ?>css/reset.css" />
        <link rel="stylesheet" href="<?php echo uri('plugins/ExhibitBuilder/views/public/exhibits/'); ?>css/style.css" />
        <!--[if !IE 7]>
                <style type="text/css">
                        #wrap {display:table;height:100%}
                </style>
        <![endif]-->

        <link href='http://fonts.googleapis.com/css?family=Signika:400,600' rel='stylesheet' type='text/css'>
            <link rel="stylesheet" href="<?php echo uri('plugins/ExhibitBuilder/views/public/exhibits/'); ?>css/jquery.ad-gallery.css" />
            <link rel="stylesheet" href="<?php echo uri('plugins/ExhibitBuilder/views/public/exhibits/'); ?>css/tabulous.css" />
            <link rel="stylesheet" href="<?php echo uri('plugins/ExhibitBuilder/views/public/exhibits/'); ?>css/jquery.fancybox.css" />

            <script src="<?php echo uri('plugins/ExhibitBuilder/views/public/exhibits/'); ?>javascript/modernizr-1.7.min.js"></script>
            <script type="text/javascript">

                var _gaq = _gaq || [];
                _gaq.push(['_setAccount', 'UA-28875549-1']);
                _gaq.push(['_trackPageview']);

                (function() {
                    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
                })();

            </script>
    </head>

    <body>
        <?php
        session_start();
// store session data
//echo $locale = Zend_Registry::get('Zend_Locale');
        $_SESSION['get_language'] = get_language_for_switch();
        $_SESSION['get_language_omeka'] = get_language_for_omeka_switch();
        $_SESSION['get_language_for_internal_xml'] = get_language_for_internal_xml();
        ?>			
        <nav class="breadcrumb">
            <div class="inner">
                <span class="title" data-translation="You_are_here">You are here</span>:
                <a href="<?php echo uri('index'); ?>" data-translation="Pathways">Pathways</a>
                <span class="bc_separator">></span>
                <span class="inactive"><?php echo h($exhibit->title); ?></span>
            </div>
        </nav>

        <section class="inner languages">

<!--			<select id="languages">
        <option value="">-- Select Language --</option>
        <option value="el">Ελληνικά</option>
        <option value="en">English</option>
        <option value="de">Deutsch</option>
        <option value="ee">Eesti</option>
        <option value="ru">Russian</option>
        <option value="pt">Português</option>
        <option value="hu">Magyar</option>
        <option value="fi">Suomi</option>
</select>-->
            <?php echo language_switcher(); ?>

        </section>

        <section class="inner slideshow">

            <div class="ad-gallery" id="ad-gallery">
                <div class="ad-image-wrapper">
                </div>
                <div class="ad-nav">
                    <div class="ad-thumbs">
                        <ul class="ad-thumb-list"></ul>
                    </div>
                </div>
            </div>

        </section>

        <section class="inner info clearfix">

            <section class="basicinfo fl"></section>

            <section class="moreinfo fr clearfix">

                <section class="fl clearfix social">

                    <a href="#" class="email" data-translation="Email">Email it!</a>
                    <a href="#" class="print" data-translation="Print">Print it!</a>
                    <a href="#" class="socbuttons fb">facebook</a>
                    <a href="#" class="socbuttons tw">twitter</a>
                    <a href="#" class="socbuttons gp">google+</a>
                    <a href="#" class="socbuttons fd">feed</a>

                </section>

                <section class="fr clearfix infoplus">

<!--<span class="time">53'</span>-->
                    <label class="ages" id="ages"></label>
                    <label class="ages" id="target"></label>

                </section>

            </section>

            <section class="paths_wrapper fl">

                <div id="tabs">
                    <ul></ul>
                    <div id="tabs_container"></div>
                </div>

                <section class="mdblock clearfix">

                    <div class="fl">

                        <h3>General</h3>
                        <div id="general-text"></div>

                        <h3>Meta-metadata</h3>
                        <div id="metametadata-text"></div>

                        <h3>Educational</h3>
                        <div id="educational-text"></div>

                        <h3 data-translation="Classification">Classification</h3>
                        <div id="classification-text"></div>


                    </div>

                    <div class="fr">

                        <h3>LifeCycle</h3>
                        <div id="lifecycle-text"></div>

                        <h3>Technical</h3>
                        <div id="technical-text"></div>

                        <h3>Rights</h3>
                        <div id="rights-text"></div>

                    </div>

                </section>

            </section>

        </section>

        <section class="inner clearfix footer">
            <a href="http://www.natural-europe.eu/"><img src="../../../plugins/ExhibitBuilder/views/public/exhibits/images/logo_n.png" /></a>
        </section>

        <div class="main-loading"></div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
        <script src="<?php echo uri('plugins/ExhibitBuilder/views/public/exhibits/'); ?>javascript/jquery.ad-gallery.js"></script>
        <script src="<?php echo uri('plugins/ExhibitBuilder/views/public/exhibits/'); ?>javascript/tabulous.js"></script>
        <script src="<?php echo uri('plugins/ExhibitBuilder/views/public/exhibits/'); ?>javascript/jquery.fancybox.js"></script>
        <script src="<?php echo uri('plugins/ExhibitBuilder/views/public/exhibits/'); ?>javascript/vcard.js"></script>
        <script src="<?php echo uri('plugins/ExhibitBuilder/views/public/exhibits/'); ?>javascript/purl.js"></script>
        <script>
			
            ;(function($){$.exist||($.extend({exist:function(a){if(null==typeof a||void 0==a)return!1;var b=!1;Array.prototype.slice.call(arguments,1);if("object"==typeof a)if(a instanceof jQuery)a.length&&$.contains(document.documentElement,a[0])&&(b=!0),$.trim(a.selector).length&&($(a.selector).length&&$.contains(document.documentElement,$(a)[0])&&(b=!0),"#"!=a.selector.charAt(0)&&"."!=a.selector.charAt(0)&&($("#"+a.selector).length?$.contains(document.documentElement,$("#"+a.selector)[0])&&(b=!0):$("."+a.selector).length&&$.contains(document.documentElement,$("."+a.selector)[0])&&(b=!0)));else{if($(a).length&&$.contains(document.documentElement,a))return!0}else"string"==typeof a&&$.trim(a).length&&($(a).length&&$.contains(document.documentElement,$(a)[0])&&(b=!0),"#"!=a.charAt(0)&&"."!=a.charAt(0)&&($("#"+a).length?$.contains(document.documentElement,$("#"+a)[0])&&(b=!0):$("."+a).length&&$.contains(document.documentElement,$("."+a)[0])&&(b=!0)));b||console.log("Not Exist:\r\n\t",a);return b}}),$.fn.extend({exist:function(){return $.exist($(this))}}))})(jQuery);
			
            ;(function($) {
				
                function htmlResize(img) {
                    img.attr("src",img.attr("data-img"));
                    img.attr("width","90");
                    img.attr("height","60");
                    alert(img.attr("data-img"));
                }
				
                // DOM Ready
                $(function() {
					
                    var gallery = [];
					
                    function getLicense(path,cname) {
                        var icon = 'none';
                        if (path=="http://www.creativecommons.org/licenses/by/3.0") {
                            icon = "<img src='../../../plugins/ExhibitBuilder/views/public/exhibits/images/by.png' />";
                        }
                        else if (path=="http://www.creativecommons.org/licenses/by-sa/3.0") {
                            icon = "<img src='../../../plugins/ExhibitBuilder/views/public/exhibits/images/by-sa.png' />";
                        }
                        else if (path=="http://www.creativecommons.org/licenses/by-nd/3.0") {
                            icon = "<img src='../../../plugins/ExhibitBuilder/views/public/exhibits/images/by-nd.png' />";
                        }
                        else if (path=="http://www.creativecommons.org/licenses/by-nc/3.0") {
                            icon = "<img src='../../../plugins/ExhibitBuilder/views/public/exhibits/images/by-nc.png' />";
                        }
                        else if (path=="http://www.creativecommons.org/licenses/by-nc-sa/3.0") {
                            icon = "<img src='../../../plugins/ExhibitBuilder/views/public/exhibits/images/by-nc-sa.png' />";
                        }
                        else if (path=="http://www.creativecommons.org/licenses/by-nc-nd/3.0") {
                            icon = "<img src='../../../plugins/ExhibitBuilder/views/public/exhibits/images/by-nc-nd.png' />";
                        }
                        return "<a href='"+path+"' target='_blank' class='"+cname+"'>"+icon+"</a>";
                    }
					
                    function setLightBox(file,size) {
                        var imgInText = {};
                        imgInText.id = Math.floor((Math.random()*900)+1);
                        imgInText.title = file.metadata.lom.general.title.value;
						
                        var ext = file.metadata.lom.general.identifier.entry.value.split('.').pop().toLowerCase();
                        if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
                            //imgInText.img = 'http://img.bitpixels.com/getthumbnail?code=29089&size='+size+'&url='+file.metadata.lom.general.identifier.entry.value+'&_dad=portal&_schema=PORTAL';
                            imgInText.img = '../../../plugins/ExhibitBuilder/views/public/exhibits/images/html_l.png';
							
                            if (file.metadata.lom.general.identifier.entry.value.indexOf("/content/thumbs/src/") != -1) {
                                var e = encodeURIComponent(file.metadata.lom.general.identifier.entry.value.replace("http://",""));
                                imgInText.img = "http://images.weserv.nl/?url="+e+"&w="+size;
                            }
							
                        } else {
                            var e = encodeURIComponent(file.metadata.lom.general.identifier.entry.value.replace("http://",""));
                            imgInText.img = "http://images.weserv.nl/?url="+e+"&w="+size;
                        }
						
                        // set icons
                        switch(ext) {                        
                            case 'pdf':
                                imgInText.img = '../../../plugins/ExhibitBuilder/views/public/exhibits/images/pdf_l.png';
                                break;
                            case 'doc':
                            case 'docx':  
                                imgInText.img = '../../../plugins/ExhibitBuilder/views/public/exhibits/images/doc_l.png';
                                break;
                            case 'zip':
                                imgInText.img = '../../../plugins/ExhibitBuilder/views/public/exhibits/images/zip_l.png';
                                break;
                            case 'ppt':
                            case 'pptx':
                            case 'pps':
                                imgInText.img = '../../../plugins/ExhibitBuilder/views/public/exhibits/images/ppt_l.png';
                                break;
                            case 'mov':
                            case 'flv':
                                imgInText.img = '../../../plugins/ExhibitBuilder/views/public/exhibits/images/movie_l.png';
                                break; 
                        }
						
						
                        imgInText.lb = '<section class="lb" id="inline'+imgInText.id+'"><h3 class="ac" data-translation="Access_the_Resource">Access the Resource:</h3>';
						
                        imgInText.lb += '<article class="clearfix lbinner">';
                        imgInText.lb += '<section class="lbleft"><h2>'+imgInText.title+'</h2><a href="'+file.metadata.lom.general.identifier.entry.value+'" target="_blank"><img src="'+imgInText.img+'" onerror="this.setAttribute(\'src\',this.getAttribute(\'data-img\'));this.setAttribute(\'width\',\'390\');this.setAttribute(\'onerror\',\'null\');" data-img="'+file.metadata.lom.general.identifier.entry.value+'" /></a>'
						
                        if (file.europeana!=undefined && file.europeana.url!=undefined) {
                            imgInText.lb += '<a class="europeana" href="'+file.europeana.url+'" target="_blank"><img src="../../../plugins/ExhibitBuilder/views/public/exhibits/images/europeana-logo-en.png" /></a>';
                        }
						
                        if (file.metadata.lom.general.description!=undefined) {
                            imgInText.lb += '<p class="descinlb">'+file.metadata.lom.general.description.value+'</p>';
                        }
						
                        imgInText.lb += '</section><section class="lbright">';
						
                        if(file.metadata.lom.general.keyword!=undefined) {
							
                            var tmpKLabel = '';
                            var tmpKValue = '';
                            if (file.metadata.lom.general.keyword instanceof Array) {
                                var tmpKeywords = [];
                                $.each( file.metadata.lom.general.keyword, function(kk,kv) {
                                    tmpKeywords.push(kv.value);
                                    tmpKLabel = kv.label;
                                });
                                tmpKValue = tmpKeywords.join(', ');
                            } else {
                                tmpKLabel =  file.metadata.lom.general.keyword.label;
                                tmpKValue = file.metadata.lom.general.keyword.value;
                            }
							
                            imgInText.lb += '<span><b>'+tmpKLabel+':</b> ';
                            imgInText.lb += tmpKValue;
                            imgInText.lb += '</span>';
							
                        }
						
                        if (file.metadata.lom.general.language!=undefined && file.metadata.lom.general.language.value!="No language") {
                            imgInText.lb += '<span><b>'+file.metadata.lom.general.language.label+':</b> '+file.metadata.lom.general.language.value+'</span>';
                        }
                        if (file.metadata.lom.educational!=undefined) {
                            //if (file.metadata.lom.educational.context!=undefined && file.metadata.lom.educational.context.value!="") {
                            //    imgInText.lb += '<span><b>'+file.metadata.lom.educational.label+':</b> '+file.metadata.lom.educational.context.value+'</span>';
                            //}
                            //if (file.metadata.lom.educational.learningResourceType!=undefined && file.metadata.lom.educational.learningResourceType.value!="") {
                            //    imgInText.lb += '<span><b>'+file.metadata.lom.educational.learningResourceType.label+':</b> '+file.metadata.lom.educational.learningResourceType.value+'</span>';
                            //}
                            if (file.metadata.lom.educational.context!=undefined && file.metadata.lom.educational.context.value!="") {
								
                                if (file.metadata.lom.educational.context instanceof Array) {
                                    var tmpcontext = [];
                                    var tmpcontextLabel = "";
                                    $.each( file.metadata.lom.educational.context, function(kk,kv) {
                                        tmpcontext.push(kv.value);
                                        tmpcontextLabel = kv.label;
                                    });
                                    imgInText.lb += '<span><b>'+tmpcontextLabel+':</b> '+tmpcontext.join(', ')+'</span>';
									
                                } else {
                                    imgInText.lb += '<span><b>'+file.metadata.lom.educational.context.label+':</b> '+file.metadata.lom.educational.context.value+'</span>';
                                }
								
								
								
                            }
                            if (file.metadata.lom.educational.learningResourceType!=undefined && file.metadata.lom.educational.learningResourceType.value!="") {
								
                                if (file.metadata.lom.educational.learningResourceType instanceof Array) {
                                    var tmpLResourceType = [];
                                    var tmpLResourceTypeLabel = "";
                                    $.each( file.metadata.lom.educational.learningResourceType, function(kk,kv) {
                                        tmpLResourceType.push(kv.value);
                                        tmpLResourceTypeLabel = kv.label;
                                    });
                                    imgInText.lb += '<span><b>'+tmpLResourceTypeLabel+':</b> '+tmpLResourceType.join(', ')+'</span>';
									
                                } else {
                                    imgInText.lb += '<span><b>'+file.metadata.lom.educational.learningResourceType.label+':</b> '+file.metadata.lom.educational.learningResourceType.value+'</span>';
                                }
								
								
								
                            }
                            if (file.metadata.lom.educational.intendedEndUserRole!=undefined && file.metadata.lom.educational.intendedEndUserRole.value!="") {
								
                                if (file.metadata.lom.educational.intendedEndUserRole instanceof Array) {
                                    var tmpUserRole = [];
                                    var tmpUserRoleLabel = "";
                                    $.each( file.metadata.lom.educational.intendedEndUserRole, function(kk,kv) {
                                        tmpUserRole.push(kv.value);
                                        tmpUserRoleLabel = kv.label;
                                    });
                                    imgInText.lb += '<span><b>'+tmpUserRoleLabel+':</b> '+tmpUserRole.join(', ')+'</span>';
									
                                } else {
                                    imgInText.lb += '<span><b>'+file.metadata.lom.educational.intendedEndUserRole.label+':</b> '+file.metadata.lom.educational.intendedEndUserRole.value+'</span>';
                                }
								
								
								
                            }
                            if (file.metadata.lom.educational.typicalAgeRange!=undefined && file.metadata.lom.educational.typicalAgeRange.value!="") {
                                if (file.metadata.lom.educational.typicalAgeRange instanceof Array) {
                                    var tmpObjAr = [];
                                    var tmpObjLabel = "";
                                    $.each( file.metadata.lom.educational.typicalAgeRange, function(kk,kv) {
                                        tmpObjAr.push(kv.value);
                                        tmpObjLabel = kv.label;
                                    });
                                    imgInText.lb += '<span><b>'+tmpObjLabel+':</b> '+tmpObjAr.join(', ')+'</span>';
									
                                } else {
                                    imgInText.lb += '<span><b>'+file.metadata.lom.educational.typicalAgeRange.label+':</b> '+file.metadata.lom.educational.typicalAgeRange.value+'</span>';
                                }
                            }
                        }
						
                        if (file.metadata.lom.metaMetadata!=undefined && file.metadata.lom.metaMetadata.contribute!=undefined) {
							
                            var vcardSample = file.metadata.lom.metaMetadata.contribute.entity.value;
                            var vcardFn = vCard.initialize(vcardSample).get_fn();
                            var vcardEmail = vCard.initialize(vcardSample).get_email();
                            var vcardOrg = vCard.initialize(vcardSample).get_org();
							
                            if (file.metadata.lom.metaMetadata.contribute.role.id=="creator") {
                                var vcardBlock = '<section class="vcard">';
                                if (vcardFn!=undefined) vcardBlock += '<span class="fn"><b data-translation="Name">Name</b><b>:</b> '+vcardFn+'</span>';
                                if (vcardEmail!=undefined) vcardBlock += '<span class="email"><b data-translation="Email">Email</b><b>:</b> '+vcardEmail+'</span>';
                                if (vcardOrg!=undefined) vcardBlock += '<span class="org"><b data-translation="Organization">Organization</b><b>:</b> '+vcardOrg+'</span>';
                                vcardBlock += '</section>';
								
                                imgInText.lb += '<span><b>'+file.metadata.lom.metaMetadata.contribute.label+':</b> '+vcardBlock+'</span>';
                            } else {
                                var vcardBlock = '<section class="vcard"><span class="fn"><b>Full Name:</b> '+vcardFn+'</span><span class="email"><b>Email:</b> '+vcardEmail+'</span></section>';
                                imgInText.lb += '<span><b>'+file.metadata.lom.metaMetadata.contribute.label+':</b> '+vcardBlock+'</span>';
                            }
							
                        }
						
                        if (file.metadata.lom.technical.format!=undefined && file.metadata.lom.technical.format.value!="") {
                            imgInText.lb += '<span><b>'+file.metadata.lom.technical.label+':</b> '+file.metadata.lom.technical.format.value+'</span>';
                        }
						
                        if(file.metadata.lom.relation!=undefined) {
							
                            relationString = '<section class="vcard">';
                            var relationLabel = "";
                            if (file.metadata.lom.relation.relation instanceof Array) {
								
                                $.each( file.metadata.lom.relation.relation, function(ck,cv) {
                                    relationLabel = file.metadata.lom.relation.label;
                                    if(cv.kind!=undefined){
                                        if (cv.kind.value!=undefined) {
                                            relationString += '<span><b>'+cv.kind.value+':</b></span>';
									
                                        }
                                        if (cv.entry.value!=undefined) {
                                            relationString += '<span> '+cv.entry.value+'</span>';
									
                                        }
                                    }
									
                                });
								
                            } else {
                                if (file.metadata.lom.relation.relation.kind!=undefined){
                                    if(file.metadata.lom.relation.relation.kind!=undefined ){
                                        if (file.metadata.lom.relation.relation.kind.value!=undefined) {
                                            relationString += '<span><b>'+file.metadata.lom.relation.relation.kind.value+':</b></span>';
									
                                        }
                                    }
                                    if(file.metadata.lom.relation.relation.entry!=undefined ){
                                        if (file.metadata.lom.relation.relation.entry.value!=undefined) {
                                            relationString += '<span> '+file.metadata.lom.relation.relation.entry.value+'</span>';
									
                                        }
                                    }
                                    relationLabel = file.metadata.lom.relation.label;
                                }
                            }
							
                            imgInText.lb += '<span><b>'+relationLabel+':</b>';
                            imgInText.lb += relationString;
                            imgInText.lb += '</section>';
                            imgInText.lb += '</span>';
                        }

                        if(file.metadata.lom.classification!=undefined) {
							
                            classificationString = '<section class="vcard">';
                            var classificationLabel = "";
                            if (file.metadata.lom.classification instanceof Array) {
								
                                $.each( file.metadata.lom.classification, function(ck,cv) {
                                    classificationLabel = cv.label;
                                    if (cv.taxonPath!=undefined) {
                                        if (cv.taxonPath instanceof Array) {
                                            $.each( cv.taxonPath, function(tk,tv) {
                                                var tvstring = tv.source.string;
                                                var taxonstr = (tv.taxon.entry.string=="undefined")?"":tv.taxon.entry.string;
                                                classificationString += '<span><b>'+tvstring+':</b> '+taxonstr+'</span>';
                                            });	
                                        } else {
                                            classificationString += '<span><b>'+cv.taxonPath.source.string+':</b> '+cv.taxonPath.taxon.entry.string+'</span>';
                                        }
										
                                    }
									
                                });
								
                            } else {
                                if (file.metadata.lom.classification.taxonPath.source!=undefined) {
                                    classificationString += '<span><b>'+file.metadata.lom.classification.taxonPath.source.string+':</b> '+file.metadata.lom.classification.taxonPath.taxon.entry.string+'</span>';
                                    classificationLabel = file.metadata.lom.classification.label;
                                }
                            }
							
                            imgInText.lb += '<span><b>'+classificationLabel+':</b>';
                            imgInText.lb += classificationString;
                            imgInText.lb += '</section>';
                            imgInText.lb += '</span>';
                        }
						
                        imgInText.lb += '</section></article>';
						
                        imgInText.lb += '</section>';
						
                        return imgInText;
						
                    }
					
                    function setSectionContent(item, resArray) {
                        var returnString = '<section id="'+item.identifierref+'" class="clearfix secwrapper"><article class="secarticle"><h2>'+item.title+'</h2>';
                        // lets get resource
                        if (resArray[item.identifierref] != undefined) {
                            if (resArray[item.identifierref].metadata.lom.general.order!=undefined && resArray[item.identifierref].metadata.lom.general.order instanceof Array) {
                                var orders = resArray[item.identifierref].metadata.lom.general.order;
                                var galIsOpened = false;
                                $.each( orders, function(ko,vo) {
									
                                    if (vo.description!=undefined && vo.description.string!=undefined) {
										
                                        if (galIsOpened) {
                                            returnString += '</aside>';
                                            galIsOpened = false;
                                        }
										
                                        returnString += '<section class="secdesc">'+vo.description.string+'</section>';
                                    }
									
                                    if (vo.file!=undefined) {
										
                                        var img = (vo.file.thumbs!=undefined)?vo.file.thumbs.full:vo.file.metadata.lom.general.identifier.entry.value;
                                        var tmpImg = "http://images.weserv.nl/?url="+img.replace("http://","")+"&w=135&h=110&t=square&a=t";
                                        var imgInText = setLightBox(vo.file,390);
										
                                        if (!galIsOpened) {
                                            returnString += '<aside class="secgal clearfix">';
                                            galIsOpened = true;
                                        }
										
                                        returnString += '<a class="lbtrigger" href="#inline'+imgInText.id+'"><img height="110" src="'+tmpImg+'" onerror="this.setAttribute(\'src\',this.getAttribute(\'data-img\'));this.setAttribute(\'height\',\'110\');this.setAttribute(\'onerror\',\'null\');" data-img="'+img+'" /><span>'+vo.file.metadata.lom.general.title.value+'</span></a>'+imgInText.lb; // thumb
										
                                        //  get images for gallery
                                        var gTmp = {};
                                        gTmp.path = vo.file.metadata.lom.general.identifier.entry.value;
                                        gTmp.title = vo.file.metadata.lom.general.title.value;
                                        if (vo.file.metadata.lom.general.description!=undefined && vo.file.metadata.lom.general.description.value!=undefined) {
                                            gTmp.description = vo.file.metadata.lom.general.description.value;
                                        } else {
                                            gTmp.description = "";
                                        }
										
                                        gallery.push(gTmp);
										
                                    }
									
                                });
                                if (galIsOpened) {
                                    returnString += '</aside>';
                                    galIsOpened = false;
                                }
								
                            }	
                        }
						
                        returnString += '</article>';
						
                        // prepare support material
                        if (resArray[item.identifierref].file != undefined) {
                            returnString += '<aside class="supmat">';
                            returnString += "<h3 data-translation='Supporting_Materials'>Supporting materials <span>for preparation</span></h3>";
                            if (resArray[item.identifierref].file  instanceof Array) {
                                $.each( resArray[item.identifierref].file, function(k,v) {
                                    returnString += setSupportMaterial(v);
                                });
                            } else {
                                returnString += setSupportMaterial(resArray[item.identifierref].file);
                            }
                            returnString += '</aside>';
                        }
						
                        returnString += '</section>';
						
                        return returnString;
                    }
					
                    function setSupportMaterial(file) {
                        var toReturn = '';
						
                        if (file.metadata.lom.general.identifier.entry.value==undefined) return '';
                        var img = file.metadata.lom.general.identifier.entry.value;
						
                        var extension = img.substr((img.lastIndexOf('.')+1));
                        switch(extension) {
                            case 'jpg':
                            case 'png':
                            case 'gif':
                                var tmpImg = "http://images.weserv.nl/?url="+encodeURIComponent(img.replace("http://",""))+"&w=100&h=75&t=square&a=t";
                                break;                         
                            case 'pdf':
                                var tmpImg = '../../../plugins/ExhibitBuilder/views/public/exhibits/images/pdf.png';
                                break;
                            case 'doc':
                            case 'docx':  
                                var tmpImg = '../../../plugins/ExhibitBuilder/views/public/exhibits/images/doc.png';
                                break;
                            case 'zip':
                                var tmpImg = '../../../plugins/ExhibitBuilder/views/public/exhibits/images/zip.png';
                                break;
                            case 'ppt':
                            case 'pptx':
                            case 'pps':
                                var tmpImg = '../../../plugins/ExhibitBuilder/views/public/exhibits/images/ppt.png';
                                break;
                            case 'mov':
                            case 'flv':
                                var tmpImg = '../../../plugins/ExhibitBuilder/views/public/exhibits/images/movie.png';
                                break; 
                            default:
                                var tmpImg = '../../../plugins/ExhibitBuilder/views/public/exhibits/images/html.png';
                            //var tmpImg = 'http://img.bitpixels.com/getthumbnail?code=29089&size=100&url='+img+'&_dad=portal&_schema=PORTAL';
                    }
						
                    var imgInText = setLightBox(file,390);
                    toReturn += '<a class="lbtrigger clearfix" href="#inline'+imgInText.id+'"><img height="75" src="'+tmpImg+'" onerror="this.setAttribute(\'src\',this.getAttribute(\'data-img\'));this.setAttribute(\'height\',\'75\');this.setAttribute(\'onerror\',\'null\');" data-img="'+file.metadata.lom.general.identifier.entry.value+'" /><span>'+file.metadata.lom.general.title.value+'</span></a>'+imgInText.lb; // thumb
						
                    return toReturn;
                }
				
                if(!$("html.ie9").exist() || !$("html.ie8").exist()) $("#tabs_container").hide();
					
                //var json = $.url().param('json');
                var json = '<?php echo $exhibit['slug']; ?>';
					
                $('#languages').bind('change', function () {
                    var lang = $(this).val(); // get selected value
                    if (lang) { // require a URL
                        window.location = window.location.pathname+"?json="+json+"&lang="+lang; // redirect
                    }
                    return false;
                });
					
                if (json!="" && json!=undefined) {
						
                    //var lang = $.url().param('lang');
                    var lang = '<?php echo $_SESSION['get_language']; ?>';
                    if (lang!="" && lang!=undefined) {
                        var language = '?lang='+lang;
                    } else var language = '';
                    console.log('<?php echo uri('exhibits/'); ?>show/'+json+language);
                    //console.log('http://localhost/natural_europe_new/exhibits/show/'+json+language);
                    $.ajax({
                        url: '<?php echo uri('exhibits/'); ?>show/'+json+language,
                        //url: 'http://localhost/natural_europe_new/exhibits/show/'+json+language,
                        type: 'GET',
                        cache: false,
                        dataType: 'jsonp',
                        jsonp: 'callback',
                        jsonpCallback: 'jsonCallback',
                        success: function(j){
                            // lets put resources in a conv array
                            var resources = j.resources.resource;
                            var resArray = [];
                            if (resources instanceof Array) {
                                $.each( resources, function(k,r) {
                                    resArray[r.identifier] = r;
                                });
                            }
								
                            var tabs = j.organizations.organization.item;
                            var tabsHeading = '';
                            var tabsBody = '';
                            var i = 0;
                            var tabID = '';
                            var tabsLength = tabs.length;
                            $("#tabs ul").addClass("tabscount"+tabsLength);
                            if (tabs instanceof Array) {
                                $.each( tabs, function(k,v) {
                                    tabID = 'tabs-'+(i++);
                                    if (i==tabsLength) var last = 'last'; else var last = '';
                                    tabsHeading += '<li><a href="#'+tabID+'" title="'+v.title+'" class="'+last+'">'+v.title+'</a></li>';
                                    tabsBody += '<div class="tabcontent" id="'+tabID+'">';
										
                                    // lets get sections
                                    var section = '';
                                    if (v.item  instanceof Array) {
                                        $.each( v.item, function(ks,vs) {
                                            if (vs!=undefined) {section += setSectionContent(vs, resArray);}
												
                                        });
                                    } else {
                                        if (v.item!=undefined) {section += setSectionContent(v.item, resArray);}
                                    }
                                    tabsBody += section+'</div>';
										
                                });
                            }
								
                            // lets try to populate the gallery
                            if (gallery.length>0) {
                                var galWrapper = $("#ad-gallery");
                                var galList = galWrapper.find("ul.ad-thumb-list");
                                $.each( gallery, function( key, imgObj ) {
                                    var thumb ="http://images.weserv.nl/?url="+imgObj.path.replace("http://","")+"&w=90&h=60&t=square&a=t";
                                    galList.append('<li><a href="'+imgObj.path+'"><img style="width:90px; height:60px;" src="'+thumb+'" title="'+imgObj.title+'" alt="'+imgObj.description+'" onerror="this.setAttribute(\'src\',this.getAttribute(\'data-img\'));this.setAttribute(\'width\',\'90\');this.setAttribute(\'height\',\'60\');this.setAttribute(\'onerror\',\'null\');" data-img="'+imgObj.path+'"></a></li>');
                                });
                                var galleries = $('#ad-gallery').adGallery({update_window_hash:false});
                            }else {
                                $("section.slideshow").remove();
                            }
								
                            //basicinfo
                            var bi = '';
                            if(j.metadata.lom.general.title.value!=undefined) {
                                bi += '<div class="astitle"><label>'+j.metadata.lom.general.title.label+':</label><span>'+j.metadata.lom.general.title.value+'</span></div>';
                            }
                            if(j.metadata.lom.general.description.value!=undefined) {
                                bi += '<div><label>'+j.metadata.lom.general.description.label+':</label><span>'+j.metadata.lom.general.description.value+'</span></div>';
                            }
                            if(j.metadata.lom.general.language.value!=undefined) {
                                bi += '<div><label>'+j.metadata.lom.general.language.label+':</label><span>'+j.metadata.lom.general.language.value+'</span></div>';
                            }
                            if(j.metadata.omeka.dateModified!=undefined) {
                                bi += '<div><label data-translation="Pathway_last_saved_at">Pathway last saved at</label><label>:</label><span>'+j.metadata.omeka.dateModified+'</span></div>';
                            }
                            if(j.metadata.lom.metaMetadata.contribute.role!=undefined && j.metadata.lom.metaMetadata.contribute.role.value=='creator') {
                                var vcardSample = j.metadata.lom.metaMetadata.contribute.entity.value;
                                vcFn = vCard.initialize(vcardSample).get_fn();
                                vcEmail = vCard.initialize(vcardSample).get_email();
                                bi += '<div><label data-translation="Name">Name</label><label>:</label><span>'+vcFn+'</span></div>';
                                bi += '<div><label data-translation="Email">Email</label><label>:</label><span>'+vcEmail+'</span></div>';
                            }
								
                            if(j.metadata.lom.educational.typicalAgeRange!=undefined) {
                                bi += '<div><label>'+j.metadata.lom.educational.typicalAgeRange.label+':</label><span>'+j.metadata.lom.educational.typicalAgeRange.value.replace("from",">").replace("years old","")+'</span></div>';
                            }
                            if(j.metadata.lom.educational.intendedEndUserRole!=undefined) {
									
                                if (j.metadata.lom.educational.intendedEndUserRole instanceof Array) {
                                    var tmpRole = [];
                                    var tmpRoleLabel = '';
                                    $.each( j.metadata.lom.educational.intendedEndUserRole, function(kr,vr) {
                                        tmpRole.push(vr.value);
                                        tmpRoleLabel = vr.label;
                                    });
                                    bi += '<div><label>'+tmpRoleLabel+':</label><span>'+tmpRole.join(', ')+'</span></div>';
                                } else {
                                    bi += '<div><label>'+j.metadata.lom.educational.intendedEndUserRole.label+':</label><span>'+j.metadata.lom.educational.intendedEndUserRole.value+'</span></div>';
                                }
                            }
								
                            // set icon in basicinfo
                            var icon = "";
                            if (j.metadata.lom.rights!=undefined && j.metadata.lom.rights.description!=undefined) {
                                icon = getLicense(j.metadata.lom.rights.description.string,'righticon');
                            }
                            $('.basicinfo').empty().html(bi+icon);
								
								
								
                            // set metablocks
                            $(".mdblock h3").click(function(event) {
                                event.preventDefault();
                                $(this).next().slideToggle('fast').prev().toggleClass('opened');
                            });
								
                            var gText = '';
                            if(j.metadata.lom.general!=undefined) {
									
                                if(j.metadata.lom.general.identifier!=undefined) {
                                    gText += '<div class="subtitle">'+j.metadata.lom.general.identifier.label+'</div>';
										
                                    if(j.metadata.lom.general.identifier.catalog!=undefined) {
                                        gText += '<div><span>'+j.metadata.lom.general.identifier.catalog.label+':</span>'+j.metadata.lom.general.identifier.catalog.value+'</div>';
                                    }
                                    if(j.metadata.lom.general.identifier.entry!=undefined) {
                                        gText += '<div><span>'+j.metadata.lom.general.identifier.entry.label+':</span>'+j.metadata.lom.general.identifier.entry.value+'</div>';
                                    }
                                }
									
                                if(j.metadata.lom.general.title!=undefined) {
                                    gText += '<div class="subtitle">'+j.metadata.lom.general.title.label+'</div>';
                                    gText += '<div>'+j.metadata.lom.general.title.value+'</div>';
                                }
									
                                if(j.metadata.lom.general.language!=undefined) {
                                    gText += '<div class="subtitle">'+j.metadata.lom.general.language.label+'</div>';
                                    gText += '<div>'+j.metadata.lom.general.language.value+'</div>';
                                }
									
                                if(j.metadata.lom.general.description!=undefined && j.metadata.lom.general.description.value) {
                                    gText += '<div class="subtitle">'+j.metadata.lom.general.description.label+'</div>';
                                    gText += '<div>'+j.metadata.lom.general.description.value+'</div>';
                                }
									
                                if(j.metadata.lom.general.keyword!=undefined) {
										
                                    var ktmp = '';
                                    var klabel = '';
                                    if (j.metadata.lom.general.keyword instanceof Array) {
                                        var tmpKeywords = [];
                                        $.each( j.metadata.lom.general.keyword, function(kk,kv) {
                                            tmpKeywords.push(kv.value);
                                            klabel = kv.label;
                                        });
                                        ktmp = '<div>'+tmpKeywords.join(', ')+'</div>';
                                    } else {
                                        ktmp = '<div>'+j.metadata.lom.general.keyword.value+'</div>';
                                        klabel = j.metadata.lom.general.keyword.label;
                                    }
										
                                    gText += '<div class="subtitle">'+klabel+'</div>'+ktmp;
										
                                }
									
                                $("#general-text").html(gText.replace(/undefined/gi,""));
                                $("#general-text").prev().text(j.metadata.lom.general.label);
									
                            } else { $("#general-text").prev().remove(); $("#general-text").remove(); }
								
								
                            var lcText = '';
                            if(j.metadata.lom.lifeCycle!=undefined) {
									
                                if(j.metadata.lom.lifeCycle.contribute!=undefined) {
										
                                    //lcText += '<div class="subtitle">Contributions</div>';
                                    if (j.metadata.lom.lifeCycle.contribute instanceof Array) {
                                        var k=1;
                                        $.each( j.metadata.lom.lifeCycle.contribute, function(lk,lv) {
												
                                            if (lv.role!=undefined) {
                                                lcText += '<div class="subtitle" data-translation="Contribution">Contribution</div>';
                                                lcText += '<div>';
                                                lcText += '<span>'+lv.role.label+':</span>';
                                                lcText += lv.role.value;
                                                lcText += '</div>';
													
                                                if (lv.entity!=undefined) {
                                                    lcText += '<div>';
                                                    lcText += '<span>'+lv.entity.label+':</span>';
														
                                                    var vc = lv.entity.value;
                                                    var vcFn = vCard.initialize(vc).get_fn();
                                                    var vcEmail = vCard.initialize(vc).get_email();
                                                    var vcOrg = vCard.initialize(vc).get_org();
                                                    lcText += '<div><span class="fn"><span data-translation="Name">Name</span>:</span>'+vcFn+'</div><div><span class="email"><span data-translation="Email">Email</span>:</span>'+vcEmail+'</div><div><span class="org"><span data-translation="Organization">Organization</span>:</span>'+vcOrg+'</div>';
														
                                                    lcText += '</div>';
                                                }
													
                                                if (lv.date!=undefined) {
                                                    lcText += '<div>';
                                                    lcText += '<span>'+lv.date.label+':</span>';
                                                    var tmpDate = lv.date.dateTime.split("T");
                                                    lcText += tmpDate[0];
                                                    lcText += '</div>';
                                                }
													
                                                k++;
                                            }
												
                                        });
											
                                    } else {
											
                                        lcText += '<div class="subtitle" data-translation="Contribution">Contribution</div>';
                                        if (j.metadata.lom.lifeCycle.contribute.role!=undefined) {
                                            lcText += '<div>';
                                            lcText += '<span>'+j.metadata.lom.lifeCycle.contribute.role.label+':</span>';
                                            lcText += j.metadata.lom.lifeCycle.contribute.role.value;
                                            lcText += '</div>';
                                        }
											
                                        if (j.metadata.lom.lifeCycle.contribute.entity!=undefined) {
                                            lcText += '<div>';
                                            lcText += '<span>'+j.metadata.lom.lifeCycle.contribute.entity.label+':</span>';
												
                                            var vc = j.metadata.lom.lifeCycle.contribute.entity.value;
                                            var vcFn = vCard.initialize(vc).get_fn();
                                            var vcEmail = vCard.initialize(vc).get_email();
                                            var vcOrg = vCard.initialize(vc).get_org();
                                            lcText += '<div><span class="fn"><span data-translation="Name">Name</span>:</span>'+vcFn+'</div><div><span class="email"><span data-translation="Email">Email</span>:</span>'+vcEmail+'</div><div><span class="org"><span data-translation="Organization">Organization</span>:</span>'+vcOrg+'</div>';
												
                                            lcText += '</div>';	
                                        }
											
                                        if (j.metadata.lom.lifeCycle.contribute.date!=undefined) {
                                            lcText += '<div>';
                                            lcText += '<span>'+j.metadata.lom.lifeCycle.contribute.date.label+':</span>';
                                            var tmpDate = j.metadata.lom.lifeCycle.contribute.date.dateTime.split("T");
                                            lcText += tmpDate[0];
                                            lcText += '</div>';
                                        }
											
                                    }
										
                                }
                                $("#lifecycle-text").html(lcText.replace(/undefined/gi,""));
                                $("#lifecycle-text").prev().text(j.metadata.lom.lifeCycle.label);
                            } else { $("#lifecycle-text").prev().remove(); $("#lifecycle-text").remove(); }
								
								
                            var mmText = '';
                            if(j.metadata.lom.metaMetadata!=undefined) {
									
                                if(j.metadata.lom.metaMetadata.identifier!=undefined) {
                                    mmText += '<div class="subtitle">'+j.metadata.lom.metaMetadata.identifier.label+'</div>';
										
                                    if(j.metadata.lom.metaMetadata.identifier.catalog!=undefined) {
                                        mmText += '<div><span>'+j.metadata.lom.metaMetadata.identifier.catalog.label+':</span>'+j.metadata.lom.metaMetadata.identifier.catalog.value+'</div>';
                                    }
                                    if(j.metadata.lom.metaMetadata.identifier.entry!=undefined) {
                                        mmText += '<div><span>'+j.metadata.lom.metaMetadata.identifier.entry.label+':</span>'+j.metadata.lom.metaMetadata.identifier.entry.value+'</div>';
                                    }
                                }
									
                                if(j.metadata.lom.metaMetadata.contribute!=undefined) {
										
                                    //mmText += '<div class="subtitle">Contributions</div>';
                                    if (j.metadata.lom.metaMetadata.contribute instanceof Array) {
                                        var k=1;
                                        $.each( j.metadata.lom.metaMetadata.contribute, function(lk,lv) {
												
                                            mmText += '<div class="subtitle" data-translation="Contribution">Contribution</div>';
                                            mmText += '<div>';
                                            mmText += '<span>'+lv.role.label+':</span>';
                                            mmText += lv.role.value;
                                            mmText += '</div>';
												
                                            if (lv.entity!=undefined) {
                                                mmText += '<div>';
                                                mmText += '<span>'+lv.entity.label+':</span>';
													
                                                var vc = lv.entity.value;
                                                var vcFn = vCard.initialize(vc).get_fn();
                                                var vcEmail = vCard.initialize(vc).get_email();
                                                var vcOrg = vCard.initialize(vc).get_org();
                                                mmText += '<div><span class="fn"><span data-translation="Name">Name</span>:</span>'+vcFn+'</div><div><span class="email"><span data-translation="Email">Email</span>:</span>'+vcEmail+'</div><div><span class="org"><span data-translation="Organization">Organization</span>:</span>'+vcOrg+'</div>';
													
                                                mmText += '</div>';
                                            }
												
                                            if (lv.date!=undefined) {
                                                mmText += '<div>';
                                                mmText += '<span>'+lv.date.label+':</span>';
                                                var tmpDate = lv.date.dateTime.split("T");
                                                mmText += tmpDate[0];
                                                mmText += '</div>';
                                            }
												
                                            k++;
                                        });
											
                                    } else {
											
                                        mmText += '<div class="subtitle" data-translation="Contribution">Contribution</div>';
                                        mmText += '<div>';
                                        mmText += '<span>'+j.metadata.lom.metaMetadata.contribute.role.label+':</span>';
                                        mmText += j.metadata.lom.metaMetadata.contribute.role.value;
                                        mmText += '</div>';
											
                                        if (j.metadata.lom.metaMetadata.contribute.entity!=undefined) {
                                            mmText += '<div>';
                                            mmText += '<span>'+j.metadata.lom.metaMetadata.contribute.entity.label+':</span>';
												
                                            var vc = j.metadata.lom.metaMetadata.contribute.entity.value;
                                            var vcFn = vCard.initialize(vc).get_fn();
                                            var vcEmail = vCard.initialize(vc).get_email();
                                            var vcOrg = vCard.initialize(vc).get_org();
                                            mmText += '<div><span class="fn"><span data-translation="Name">Name</span>:</span>'+vcFn+'</div><div><span class="email"><span data-translation="Email">Email</span>:</span>'+vcEmail+'</div><div><span class="org"><span data-translation="Organization">Organization</span>:</span>'+vcOrg+'</div>';
												
                                            mmText += '</div>';	
                                        }
											
                                        if (j.metadata.lom.metaMetadata.contribute.date!=undefined) {
                                            mmText += '<div>';
                                            mmText += '<span>'+j.metadata.lom.metaMetadata.contribute.date.label+':</span>';
                                            var tmpDate = j.metadata.lom.metaMetadata.contribute.date.dateTime.split("T");
                                            mmText += tmpDate[0];
                                            mmText += '</div>';
                                        }
											
                                    }
										
                                }
									
                                if(j.metadata.lom.metaMetadata.metadataSchema!=undefined) {
                                    mmText += '<div class="subtitle">'+j.metadata.lom.metaMetadata.metadataSchema.label+'</div>';
                                    mmText += '<div>'+j.metadata.lom.metaMetadata.metadataSchema.value+'</div>';
                                }
									
                                if(j.metadata.lom.metaMetadata.language!=undefined) {
                                    mmText += '<div class="subtitle">'+j.metadata.lom.metaMetadata.language.label+'</div>';
                                    mmText += '<div>'+j.metadata.lom.metaMetadata.language.value+'</div>';
                                }
                                $("#metametadata-text").html(mmText.replace(/undefined/gi,""));
                                $("#metametadata-text").prev().text(j.metadata.lom.metaMetadata.label);
                            } else { $("#metametadata-text").prev().remove(); $("#metametadata-text").remove(); }
								
								
                            var tText = '';
                            if(j.metadata.lom.technical!=undefined) {
									
                                if(j.metadata.lom.technical.location!=undefined) {
                                    tText += '<div class="subtitle">'+j.metadata.lom.technical.location.label+'</div>';
                                    tText += '<div>'+j.metadata.lom.technical.location.value+'</div>';
                                }
									
                                if(j.metadata.lom.technical.format!=undefined) {
                                    tText += '<div class="subtitle">'+j.metadata.lom.technical.format.label+'</div>';
                                    tText += '<div>'+j.metadata.lom.technical.format.value+'</div>';
                                }
                                $("#technical-text").html(tText.replace(/undefined/gi,""));
                                $("#technical-text").prev().text(j.metadata.lom.technical.label);
                            } else { $("#technical-text").prev().remove(); $("#technical-text").remove(); }
								
								
                            var eText = '';
                            if(j.metadata.lom.educational!=undefined) {
									
                                if(j.metadata.lom.educational.learningResourceType!=undefined) {
										
                                    if (j.metadata.lom.educational.learningResourceType instanceof Array) {
                                        var tmpRType = [];
                                        var tmpRTypeLabel = '';
                                        $.each( j.metadata.lom.educational.learningResourceType, function(krt,vrt) {
                                            tmpRType.push(vrt.value);
                                            tmpRTypeLabel = vrt.label;
                                        });
											
                                        eText += '<div class="subtitle">'+tmpRTypeLabel+'</div>';
                                        eText += '<div>'+tmpRType.join(', ')+'</div>';
											
                                    } else {
                                        eText += '<div class="subtitle">'+j.metadata.lom.educational.learningResourceType.label+'</div>';
                                        eText += '<div>'+j.metadata.lom.educational.learningResourceType.value+'</div>';
                                    }
										
                                }
									
                                if(j.metadata.lom.educational.intendedEndUserRole!=undefined) {
										
                                    if (j.metadata.lom.educational.intendedEndUserRole instanceof Array) {
                                        var tmpRole = [];
                                        var tmpRoleLabel = '';
                                        $.each( j.metadata.lom.educational.intendedEndUserRole, function(kr,vr) {
                                            tmpRole.push(vr.value);
                                            tmpRoleLabel = vr.label;
                                        });
											
                                        eText += '<div class="subtitle">'+tmpRoleLabel+'</div>';
                                        eText += '<div>'+tmpRole.join(', ')+'</div>';
											
                                    } else {
                                        eText += '<div class="subtitle">'+j.metadata.lom.educational.intendedEndUserRole.label+'</div>';
                                        eText += '<div>'+j.metadata.lom.educational.intendedEndUserRole.value+'</div>';
                                    }
										
                                }
									
                                if(j.metadata.lom.educational.context!=undefined) {
										
                                    if (j.metadata.lom.educational.context instanceof Array) {
                                        var tmpCtx = [];
                                        var tmpCtxLabel = '';
                                        $.each( j.metadata.lom.educational.context, function(kct,vct) {
                                            tmpCtx.push(vct.value);
                                            tmpCtxLabel = vct.label;
                                        });
											
                                        eText += '<div class="subtitle">'+tmpCtxLabel+'</div>';
                                        eText += '<div>'+tmpCtx.join(', ')+'</div>';
											
                                    } else {
                                        eText += '<div class="subtitle">'+j.metadata.lom.educational.context.label+'</div>';
                                        eText += '<div>'+j.metadata.lom.educational.context.value+'</div>';
                                    }
										
                                }
									
                                if(j.metadata.lom.educational.typicalAgeRange!=undefined) {
                                    eText += '<div class="subtitle">'+j.metadata.lom.educational.typicalAgeRange.label+'</div>';
                                    eText += '<div>'+j.metadata.lom.educational.typicalAgeRange.value+'</div>';
                                }
                                $("#educational-text").html(eText.replace(/undefined/gi,""));
                                $("#educational-text").prev().text(j.metadata.lom.educational.label);
                            } else { $("#educational-text").prev().remove(); $("#educational-text").remove(); }
								
								
                            var rText = '';
                            if(j.metadata.lom.rights!=undefined) {
									
                                if(j.metadata.lom.rights.copyrightAndOtherRestrictions!=undefined) {
                                    rText += '<div class="subtitle" data-translation="Copyright_and_other_Restrictions">Copyright and other Restrictions</div>';
                                    rText += '<div>'+j.metadata.lom.rights.copyrightAndOtherRestrictions.value+'</div>';
                                }
									
                                if(j.metadata.lom.rights.cost!=undefined) {
                                    rText += '<div class="subtitle" data-translation="Cost">Cost</div>';
                                    rText += '<div>'+j.metadata.lom.rights.cost.value+'</div>';
                                }
									
                                if(j.metadata.lom.rights.description!=undefined) {
                                    rText += '<div class="subtitle" data-translation="License">License</div>';
                                    rText += '<div>'+getLicense(j.metadata.lom.rights.description.string)+'</div>';
                                }
                                $("#rights-text").html(rText.replace(/undefined/gi,""));
                                $("#rights-text").prev().text(j.metadata.lom.rights.label);
                            } else { $("#rights-text").prev().remove(); $("#rights-text").remove(); }
								
								
                            var cText = '';
                            if(j.metadata.lom.classification!=undefined) {
									
                                if (j.metadata.lom.classification instanceof Array) {
										
                                    $.each( j.metadata.lom.classification, function(ck,cv) {
											
                                        if (cv.taxonPath!=undefined) {
                                            if (cv.taxonPath instanceof Array) {
                                                $.each( cv.taxonPath, function(tk,tv) {
                                                    cText += '<div><span>'+tv.source.string+':</span>'+tv.taxon.entry.string+'</div>';
                                                });	
                                            } else {
                                                cText += '<div><span>'+cv.taxonPath.source.string+':</span>'+cv.taxonPath.taxon.entry.string+'</div>';
                                            }
												
                                        }
											
                                    });
										
                                }else{
                                    var cv = j.metadata.lom.classification;						
                                    if (cv.taxonPath!=undefined) {
                                        if (cv.taxonPath instanceof Array) {
                                            $.each( cv.taxonPath, function(tk,tv) {
                                                cText += '<div><span>'+tv.source.string+':</span>'+tv.taxon.entry.string+'</div>';
                                            });	
                                        } else {
                                            cText += '<div><span>'+cv.taxonPath.source.string+':</span>'+cv.taxonPath.taxon.entry.string+'</div>';
                                        }
												
                                    }
											
   
                                }
                                $("#classification-text").html(cText.replace(/undefined/gi,""));
                                $("#classification-text").prev().text(j.metadata.lom.classification.label);
                            }  else { $("#classification-text").prev().remove(); $("#classification-text").remove(); }
								
                            $("#tabs ul").html(tabsHeading);
                            $("#tabs_container").html(tabsBody);
								
                            // fixed translations
                            var translations = j.records.record;
                            if (translations instanceof Array) {
									
                                $.each( translations, function(rk,translation) {
										
                                    if (translation.id) {
											
                                        if (translation.english_translation) {
                                            //$("#"+translation.id).text(translation.english_translation);
                                            $('*[data-translation="'+translation.id+'"]').text(translation.english_translation);
                                        } else {
                                            //$("#"+translation.id).text(translation.english_value);
                                            $('*[data-translation="'+translation.id+'"]').text(translation.english_value);
                                        }
											
                                    }
										
										
                                });
									
                            }
								
                            $(".lbtrigger").fancybox();
                            if($("html").hasClass("ie9") || $("html").hasClass("ie8")) {
                                $('#tabs').tabulous({ effect: 'slideLeft' });
                                var count = $("#tabs > ul").children().length-1;
                                var width = parseInt($("#tabs > ul").css("width"));
                                var newWidth = Math.floor(width/count)-22;
                                $("#tabs > ul > li > a").css('width',newWidth+'px');
									
                                $(".main-loading").addClass("hidden");
                            }
								
                            $(document).trigger('tb');
							    
                        }
                    });
						
						
                }
					
		       
            });
		       
        })(jQuery);
			
        $(document).bind('tb', function(){
            if(!$("html.ie9").exist() || !$("html.ie8").exist())
            {
                $("#tabs_container").show();
                $('#tabs').tabulous({ effect: 'slideLeft' });
            }
				
            // tabs width
            var count = $("#tabs > ul").children().length-1;
            var width = parseInt($("#tabs > ul").css("width"));
            var newWidth = Math.floor(width/count)-22;
            $("#tabs > ul > li > a").css('width',newWidth+'px');
				
            if(!$("html.ie9").exist() || !$("html.ie8").exist())
            {
                $(".main-loading").addClass("hidden");
            }
        });
			
        </script>

    </body>

</html>