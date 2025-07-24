document.addEventListener("DOMContentLoaded", function(event) {
    let body =  document.getElementsByTagName("body")[0];
    let notifyDiv = document.createElement('div');
    notifyDiv.id = 'notify-container';
    body.insertBefore(notifyDiv, body.firstChild);
});

let notify = (function() {
    let success = function(params) {
        params.tipo = 'success';
        return addNotify(params);
    };
    let info = function(params) {
        params.tipo = 'info';
        return addNotify(params);
    };
    let danger = function(params) {
        params.tipo = 'danger';
        return addNotify(params);
    };
    let warning = function(params) {
        params.tipo = 'warning';
        return addNotify(params);
    };

    let addNotify = function(params) {
        closeAll();
        let item = document.createElement('div');

        item.className = 'notify';
        item.classList.add(params.tipo);
        item.setAttribute('role','alert');

        let msj = document.createElement('p');
        msj.innerText = params.msj;
        item.appendChild(msj);

        if ( params.list ) {
            let ul = document.createElement('ul');
            switch (typeof params.list) {
                case 'object':
                    for (let e in params.list) {
                        let li = document.createElement('li');
                        li.innerText = params.list[e];
                        ul.appendChild(li);
                    }
                    item.appendChild(ul);                    
                    break;            
                case 'array':
                    params.list.forEach(function (e) {
                        let li = document.createElement('li');
                        li.innerText = e;
                        ul.appendChild(li);
                    });
                    item.appendChild(ul);
                    break;
            }
        }
        
        if ( params.button ) {
            let btn = document.createElement('a');
            btn.innerText = params.button;
            btn.className = 'notify-link';
            btn.setAttribute('href',params.link);
            btn.setAttribute('role','button');
            btn.setAttribute('aria-label','click aqui para '+params.button);
            item.appendChild(btn);
        }

        let close = document.createElement('button');
        close.innerHTML = '&times;';
        close.className = 'close-notify';
        close.setAttribute('title','cerrar');
        close.setAttribute('aria-label','cerrar notificacion');
        close.addEventListener("click", ()=>{
            item.style.opacity = 0;
        });
        item.appendChild(close);      
        document.getElementById('notify-container').insertAdjacentElement('afterbegin', item)
        item.offsetHeight;
        item.style.opacity = 1;
        setTimeout(() => {
            item.style.opacity = 0;
        }, 5000);
        function removeNotif(e) {
            if(e.propertyName !== 'opacity') return;
            if(this.style.opacity == 0) {
                this.parentNode.removeChild(this);
            }
        }
        item.addEventListener('transitionend',removeNotif);


    }

    let closeAll = function () {
        let notificaciones = document.getElementById('notify-container');
        notificaciones.childNodes.forEach((notif)=>{
            notif.style.opacity = 0;
            notif.style.right = '-20000px';
        });
    }
    return {
    success: success,
    info: info,
    danger: danger,
    warning: warning,
    closeAll: closeAll
    };
    
})();
