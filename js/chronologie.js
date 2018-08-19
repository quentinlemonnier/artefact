/* SCROLL PROGRESS */
function fProgressBar(current) {
    /* http://stackoverflow.com/questions/19700020/change-progress-bar-value-based-on-scrolling */
    var s = jQuery(window).scrollTop(),
    d = jQuery(document).height(),
    c = jQuery(window).height();
    scrollPercent = (s / (d - c)) * 100;
    if(scrollPercent <= 1){
     scrollPercent = 1;
    }
    var position = scrollPercent;
    jQuery("#progressbar").progressbar({
        value: position
    });
} ;

/*function dump (objName) {
    for (var i = 0; i < objName.length; i++) {

        var s = "";
        s+= objName[i];
        return(s);
    }
}*/


function linkMouvementToArtiste(artiste,mouvement,color){
    var attr = jQuery("#"+artiste).attr("dataMouvement");
    attr += jQuery("#"+artiste).attr("dataMouvement", mouvement);
   //jQuery("#"+artiste).attr("dataColor", color);
    var artisteLi = artiste+" ul li.circle";
    jQuery("#"+artiste).attr("style","background-color:#"+color);
    return false;
    
            /* AJOUT DE LA COULEUR DE L'ARTISTE */ 
      /*  jQuery('.circle.colorBg2').delay(2000).each(function(i){
            var color = jQuery(this).parent().parent().parent().attr("dataColor");
            jQuery(this).attr("style","background-color:#"+color);
        });*/
    
}


function getArtistes(url){
        /* http://www.9lessons.info/2009/10/json-jquery-ajax-php.html */
        $.getJSON(url,function(data)
        {
        /*$.each(data, function(i,data)
        {
        var div_data =
        "<div ><a title='"+data.naissance+"'>"+data.artisteNom+"</a></div>";
        jQuery(div_data).appendTo("section");
        });*/
            var items = [];
            var timeline = []
              $.each( data, function( key, val ) {
                items.push( "<article id='artiste" + val.artisteID + "' dataArtiste='"+ val.artiste +"' dataArtistePrenom='" + val.artistePrenom + "' dataStart='" + val.start + "' dataEnd='" + val.end + "' dataInterval='"+(val.end - val.start)+"' dataWork='"+val.work+"' dataArtisteUrl='"+ val.artisteUrl +"' dataOeuvreTitre='"+ val.oeuvreTitre +"' dataOeuvreUrl='"+ val.oeuvreUrl +"' dataOeuvreDate='"+ val.oeuvreDate +"' dataOeuvreCartel='"+ val.oeuvreCartel +"' dataPermalink='"+ val.permalink +"' dataSource='"+ val.permalink +"' onclick=\"javascript:popUpArtiste('#"+val.artisteNom+"');return false\" style='display:none'><!--<ul class='containercircle'><li>" + val.start + " - " + val.end + "</li><li><div id='artiste' class='circle colorBg2' >"+val.artisteNom+"</div></li><ul>--><!--<br><h1 id='"+key+"'>(" + val.start + " - " + val.end + ") " + val.artistePrenom + " " + val.artisteNom + "</h1>-->");
                 //timeline.push("<li><div class='circle colorBg2'><span style='line-height:1.2'>" + val.artisteNom  + "<br>" + val.start  + "</span></div><small>" + val.start  + "-" + val.end + " <div style='background:#000;width:5px height:3px;font-size:3px;'> </div><a href='#"+key+"'><!--" + val.artistePrenom + "--> " + val.artisteNom + "</a></small> -</li>");
              });
            
              /*            jQuery( "<ul/>", {
                "class": "artistes",
                html: timeline
              }).appendTo( "nav" );*/

              jQuery( "<section/>", {
                "class": "artistes",
                html: items
              }).appendTo( "body" );
        }
        );
        return false;   
}

function getMouvements(url){
        /* http://www.9lessons.info/2009/10/json-jquery-ajax-php.html */
        $.getJSON(url,function(data)
        {
        /*$.each(data, function(i,data)
        {
        var div_data =
        "<div ><a title='"+data.naissance+"'>"+data.artisteNom+"</a></div>";
        jQuery(div_data).appendTo("section");
        });*/
            
            var items = [];
            var name = [];
            
            var coY = 0; 
            
              $.each( data, function( key, val ) {
                  
                   //sys.addEdge(dataId, startDv);
        /*var peintre = sys.addNode('peintre',{'color':'#D42000','shape':'dot','label':'graphiste'});
        sys.addEdge(monguzzi, peintre);*/
                  
                  coY +=  30;
                  coY2 = coY + 30;
                  
                /* AJOUT DU MOUVEMENT ARTISTIQUE */
                var dataMouvementId = sys.addNode(key,{'color':'#'+val.color,'shape':'dot','label':val.mouvement,'link':'#mouvement'+val.mouvementID,'alpha': 1,'mass': 12});
                /* AJOUT DE L'année du mouvement */
                //var dataMouvementYear = sys.addNode(key+"year",{'color':'#4C4C4C','shape':'dot','label':val.start+" - "+val.end,'link':"#mouvement"+val.mouvementID,'alpha': 1,'mass': 12});
                //sys.addEdge(dataMouvementId, dataMouvementYear);
                  
                /*var dataArtisteId = sys.addNode("artiste"+key,{'color':'#D42000','shape':'naviguate','label':"artiste"+key,link:'#'+artisteNom,'alpha': 0}); 
                var DataMouvementAristesEdges = sys.addEdge(dataMouvementId, dataArtisteId);*/
    
                  
                var reg=new RegExp("[,;]+", "g");
                var regSpace=new RegExp("[ ,;]+", "g");
                var artistesData = val.artistes;
                  //console.warn(artistesData);
                var artistes = [];
                var tableArtistes=artistesData.split(reg);
                if(tableArtistes.length > 1){
                /* PLUSIEURS ARTISTES */
                    for (var i=0; i<tableArtistes.length; i++) {
                        //var artisteNom = tableArtistes[i].replace(regSpace,"");
                        var artisteID = tableArtistes[i].replace(regSpace,"");
                        var artisteNom = jQuery("#artiste"+artisteID).attr("dataArtiste");
                     artistes+="<a href='#artiste"+artisteID+"' onclick=\"javascript:popUpArtiste('#artiste"+artisteID+"');return false\">" + artisteNom + "</a> ";
                        /* AJOUT ET LIEN DES ARTISTES */
                        var dataArtisteId = sys.addNode("artiste"+key+i,{'color':'#D42000','shape':'naviguate','label':artisteNom,link:'#artiste'+artisteID,'alpha': 0,'mass':10});
                        sys.addEdge(dataMouvementId, dataArtisteId,{length:.75});
                         //var dataArtisteId = sys.addNode(key+i,{'color':'#D42000','shape':'naviguate','label':artisteNom,link:'#'+artisteNom});
                //dataNode = sys.addEdge(dataMouvementId, dataArtisteId);
                        //delete dataArtisteId;
                        linkMouvementToArtiste(artisteNom,val.mouvement,val.color);
                    }
                }else{
                /* UN ARTISTE */
                    var artisteID = artistesData;
                    var artisteNom = jQuery("#artiste"+artisteID).attr("dataArtiste");
                     artistes+="<a href='#artiste"+artisteID+"' onclick=\"javascript:popUpArtiste('#artiste"+artisteID+"');return false\">" + artisteNom + "</a> ";
                    var dataArtisteId = sys.addNode("artiste"+key+1,{'color':'#D42000','shape':'naviguate','label':artisteNom,link:'#artiste'+artisteID,'alpha': 0,'mass':10});
                        sys.addEdge(dataMouvementId, dataArtisteId);
                    linkMouvementToArtiste(artistesData,val.mouvement,val.color);
                }
                //console.warn(val.mouvementID); 
               items.push( "<article id='mouvement" + val.mouvementID + "' dataMouvement='"+val.mouvement+"' dataMouvementDescription='"+val.description.replace(/\'/g,"&#39;")+"' dataMouvementArtistes='"+val.artistes+"' dataPermalink='"+val.permalink+"'><h1>" + val.mouvement + " </h1><h2 class='date'>" + val.start + " - " + val.end + "</h2> <!--<p>Artistes : "+ artistes + " <p>--> <div id='node"+dataMouvementId.name+"Data' dataArtistes='"+val.artistes+"' ></div> </article>" );
              });

            delete dataMouvementId;
              jQuery( "<section/>", {
                "class": "mouvements",
                html: items
              }).appendTo( "body" );
        }
        );   
}

function opacityArtiste(nom){
 jQuery('#'+nom+' .circle').css("opacity","0.6").css("text-decoration","underline");
 return false;
}

function scrollArtiste(nom,alpha){
    if(alpha==0){
        jQuery("#popArtiste").fadeOut();
        opacityArtiste(nom);
    }else if(alpha == 1){
        jQuery("#popMouvement").fadeOut();
    }
    jQuery("body").animate({scrollTop: jQuery('#'+nom).offset().top-300}, 3000,'easeInOutCubic');
    return false;
}