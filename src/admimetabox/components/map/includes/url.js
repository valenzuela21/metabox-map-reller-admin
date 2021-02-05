import Vue from 'vue';

const URL = window.location.hostname;
const SLL = window.location.protocol;

let currentUrl = window.location.href;
let currentPath = currentUrl.substr( currentUrl.indexOf('?post='));
currentPath = currentPath.split("&");
currentPath = currentPath[0].split("=");

let urlGeneral, urlDelete, urlGeneralMap, urlInsert, urlUpdate;

if(URL === 'localhost'){
    urlGeneralMap = `${SLL}//${URL}:8888/tiendaubicacion/wp-content/plugins/metabox-master-tendero/includes/Api/consult_map_xml.php?id=${currentPath[1]}`;
    urlGeneral = `${SLL}//${URL}:8888/tiendaubicacion/wp-content/plugins/metabox-master-tendero/includes/Api/consult_country_json.php?id=${currentPath[1]}`;
    urlDelete = `${SLL}//${URL}:8888/tiendaubicacion/wp-content/plugins/metabox-master-tendero/includes/Api/delete_country.php`;
    urlInsert = `${SLL}//${URL}:8888/tiendaubicacion/wp-content/plugins/metabox-master-tendero/includes/Api/insert_country.php`;
    urlUpdate = `${SLL}//${URL}:8888/tiendaubicacion/wp-content/plugins/metabox-master-tendero/includes/Api/modify_country.php`;
}else{
    urlGeneralMap = `${SLL}//${URL}/wp-content/plugins/metabox-master-tendero/includes/Api/consult_map_xml.php?id=${currentPath[1]}`;
    urlGeneral = `${SLL}//${URL}/wp-content/plugins/metabox-master-tendero/includes/Api/consult_country_json.php?id=${currentPath[1]}`;
    urlDelete = `${SLL}//${URL}/wp-content/plugins/metabox-master-tendero/includes/Api/delete_country.php`;
    urlInsert = `${SLL}//${URL}/wp-content/plugins/metabox-master-tendero/includes/Api/insert_country.php`;
    urlUpdate = `${SLL}//${URL}/wp-content/plugins/metabox-master-tendero/includes/Api/modify_country.php`;
}

Vue.prototype.urlGeneralConsult = urlGeneral;
Vue.prototype.urlGeneralDelete = urlDelete;
Vue.prototype.urlGeneralMap = urlGeneralMap;
Vue.prototype.urlInsert = urlInsert;
Vue.prototype.urlUpdate = urlUpdate;



