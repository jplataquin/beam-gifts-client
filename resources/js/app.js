import './bootstrap';

import * as bootstrap from 'bootstrap';

window.util = {};

window.util.spaceToDash = (text) =>{

    return text.replace(/\s+/g," ").replace(/\s/g,'-');
}

window.util.$get = async (url,data) => {

    return fetch(url+'?'+ new URLSearchParams(data),
    {
        headers: {
            "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').content
        },
        method: "GET"
    }).then((response) => response.json())
    .then((reply=>{
        
        if(!reply.status){
            alert(reply.message);
            return false;
        }

        return reply;

    })).catch(e=>{

        return {
            status:0,
            message:e,
            data:{}
        }
    });
}

window.util.$post = async (url,formData) => {

    return fetch(url,
    {
        headers: {
            "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').content,
            "Accept": "application/json"
        },
        body: formData  ?? {},
        method: "POST"
    }).then((response) => {
       
        if(response.status == 401){
            return {
                    status:-1,
                    message:'Please sign in',
                    data:{}
            }
        };

        if(response.status == 500){

            console.error(response);
            return {
                    status:0,
                    message:'Something went wrong',
                    data:{}
            }
        };

        return response.json();
    }).catch(e=>{

        return {
            status:0,
            message:e,
            data:{}
        }
    });
}

window.util.addToCart = (data) =>{

    const formData = new FormData();

    formData.append('id',data.id);
    formData.append('qty',data.qty);

    return window.util.$post('/add-cart',formData);
}


window.util.removeFromCart = (data) =>{

}

window.util.updateCart = (data) =>{

}


window.util.clearCart = (data) =>{

}


