//Поиск в реальном времени для документов
document.querySelector('#elastic_access').oninput = function(){
    let val = this.value.trim();
    let elasticItems = document.querySelectorAll('.request');
    console.log(elasticItems);
    if(val != ''){
        elasticItems.forEach(function(elem){
            if(elem.innerText.search(val) == -1){
                elem.classList.add('hidden');
            }
            else{
                elem.classList.remove('hidden');
            }
        });
    }
    else {
        elasticItems.forEach(function(elem){
            elem.classList.remove('hidden');
        });
    }
}



