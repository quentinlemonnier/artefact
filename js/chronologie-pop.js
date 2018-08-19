function popUpArtiste(nom){
    var popup = "#popArtiste";
    var permalink = jQuery(nom).attr("dataPermalink");
    
    //jQuery(popup).css("background","#212121 url('"+jQuery(nom).attr("dataoeuvreurl")+"')");
    
    jQuery(popup+" img.circle").attr("src",jQuery(nom).attr("dataArtisteUrl"));
    jQuery(popup+" h1").html(jQuery(nom).attr("dataArtiste"));
    /*jQuery(popup+" h1").attr("dataNom",jQuery(nom).attr("id"));
    jQuery(popup+" h2").html(jQuery(nom).attr("dataStart")+" - "+jQuery(nom).attr("dataEnd"));
    jQuery(popup+" h3").html(jQuery(nom).attr("dataWork"));
    jQuery(popup+" h4").html(jQuery(nom).attr("dataMouvement"));
    jQuery(popup+" h5").html(jQuery(nom).attr("dataOeuvreDate")+" "+jQuery(nom).attr("dataOeuvreTitre"));
    jQuery(popup+" h6").html(jQuery(nom).attr("dataOeuvreCartel"));
    jQuery(popup+" .source").attr("href",jQuery(nom).attr("dataSource"));
    */jQuery(popup+" .oeuvre").parent().attr("href",jQuery(nom).attr("dataOeuvreUrl"));
    jQuery(popup+" .source").attr("href",permalink);
    jQuery(popup+" .oeuvre").attr("src",jQuery(nom).attr("dataoeuvreurl"));/*
    opacityArtiste(jQuery(nom).attr("id"));*/
    jQuery(popup).fadeIn();
    return false;
}

function returnMouvement(mouvement){
    /*var returnMouvement = mouvement.replace(/ /g, '_');
    returnMouvement = returnMouvement.replace("/","-");*/
    return mouvement;  
}

function popUpMouvement(nom){
    var popup = "#popMouvement";
    var permalink=jQuery(nom).attr("dataPermalink");
    
    jQuery(popup).fadeIn();
    jQuery(popup+" h1").html(jQuery(nom).attr("dataMouvement"));
    jQuery(popup+" .content").html(jQuery(nom).attr("dataMouvementDescription"));   
    
                var reg=new RegExp("[,;]+", "g");
                var regSpace=new RegExp("[ ,;]+", "g");
                var artistesData = jQuery(nom).attr("dataMouvementArtistes");
                var artistes = " ";
                var tableArtistes=artistesData.split(reg);
                if(tableArtistes.length > 1){
                /* PLUSIEURS ARTISTES */
                    for (var i=0; i<tableArtistes.length; i++) {
                        var artisteID = tableArtistes[i].replace(regSpace,"");
                        var artisteNom = jQuery("#artiste"+artisteID).attr("dataArtiste");
                     artistes+="<li><a href='#' onclick='javascript:popUpArtiste(\"#artiste" + artisteID + "\");return false;'>" + artisteNom + "</a></li>";
                        /* AJOUT ET LIEN DES ARTISTES */
                    }
                }else{
                /* UN ARTISTE */
                    var artisteNom = jQuery("#artiste"+artistesData).attr("dataArtiste");
                     artistes ="<li><a href='#' onclick='javascript:popUpArtiste(\"#artiste" + artistesData + "\");return false;'>" + artisteNom + "</a></li>";
                }
    jQuery(popup+" ul.artistes").html(artistes);
    
    return false;
}