document.querySelector('#elastic').oninput = function(){

    let val = this.value.trim();
    let elasticItems = document.querySelectorAll('.searchRow');
    console.log(elasticItems);

    if(val != ''){
        elasticItems.forEach(function(elem){
            
            if(elem.innerText.search(val) == -1){
                elem.classList.add('hidden');
                //obj.innerHTML = obj.innerText;
            }
            else{
                elem.classList.remove('hidden');
                //let str = obj.innerText;
                //obj.innerHTML = insertMark(str, obj.innerText.search(val), val.length);
            }
        });
    }
    else {
        elasticItems.forEach(function(elem){
            elem.classList.remove('hidden');
        });
    }
}




function insertMark(string, pos, len){
    return string.slice(0, pos) + '<mark>' + string.slice(pos, pos + len) + '</mark>' + string.slice(pos + len);
}