function popUpArtiste(nom){
    var popup = "#popArtiste"; 
    $(popup+" img.circle").attr("src",$(nom).attr("dataArtisteUrl"));
    $(popup+" h1").html($(nom).attr("dataArtistePrenom")+" "+$(nom).attr("id"));
    $(popup+" h1").attr("dataNom",$(nom).attr("id"));
    $(popup+" h2").html($(nom).attr("dataStart")+" - "+$(nom).attr("dataEnd"));
    $(popup+" h3").html($(nom).attr("dataWork"));
    $(popup+" h4").html($(nom).attr("dataMouvement"));
    $(popup+" h5").html($(nom).attr("dataOeuvreDate")+" "+$(nom).attr("dataOeuvreTitre"));
    $(popup+" h6").html($(nom).attr("dataOeuvreCartel"));
    $(popup+" .source").attr("href",$(nom).attr("dataSource"));
    $(popup+" .oeuvre").parent().attr("href",$(nom).attr("dataOeuvreUrl"));
    $(popup+" .oeuvre").attr("src",$(nom).attr("dataOeuvreUrl"));
    opacityArtiste($(nom).attr("id"));
    $(popup).fadeIn();
    return false;
}

function returnMouvement(mouvement){
    var returnMouvement = mouvement.replace(/ /g, '_');
    returnMouvement = returnMouvement.replace("/","-")
    return returnMouvement;  
}

function popUpMouvement(nom){
    var popup = "#popMouvement"; 
    $(popup).fadeIn();
    $(popup+" h1").html($(nom).attr("dataMouvement"));
    $(popup+" .content").html($(nom).attr("dataMouvementDescription"));   
    
                var reg=new RegExp("[,;]+", "g");
                var regSpace=new RegExp("[ ,;]+", "g");
                var artistesData = $(nom).attr("dataMouvementArtistes");
                var artistes = " ";
                var tableArtistes=artistesData.split(reg);
                if(tableArtistes.length > 1){
                /* PLUSIEURS ARTISTES */
                    for (var i=0; i<tableArtistes.length; i++) {
                        var artisteNom = tableArtistes[i].replace(regSpace,"");
                     artistes+="<li><a href='#' onclick='javascript:popUpArtiste(\""+"#"+artisteNom+"\");return false;'>" + artisteNom + "</a></li>";
                        /* AJOUT ET LIEN DES ARTISTES */
                    }
                }else{
                /* UN ARTISTE */
                     artistes ="<li><a href='#' onclick='javascript:popUpArtiste(\""+"#"+artistesData+"\");return false;'>" + artistesData + "</a></li>";
                }
    $(popup+" ul.artistes").html(artistes);
    
    return false;
}