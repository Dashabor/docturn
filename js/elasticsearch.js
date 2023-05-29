//Поиск в реальном времени
document.querySelector('#elastic').oninput = function(){
    let val = this.value.trim();
    let elasticItems = document.querySelectorAll('.searchRow');
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
