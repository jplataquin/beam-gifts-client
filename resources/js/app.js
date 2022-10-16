import './bootstrap';

window.util = {};

window.util.spaceToDash = (text) =>{

    return text.replace(/\s+/g," ").replace(/\s/g,'-');
}

window.util.$get = async (url,data) => {

    let status = '';
    
    return fetch(url+'?'+ new URLSearchParams(data),
    {
        headers: {
            "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').content
        },
        method: "GET"
    }).then((response) => {
        
        status = response.status;

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
            message:e.message,
            data:{
                httpStatus: status
            }
        }
    });
}

window.util.$post = async (url,formData) => {

    let status = '';

    return fetch(url,
    {
        headers: {
            "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').content,
            "Accept": "application/json"
        },
        body: formData  ?? {},
        method: "POST"
    }).then((response) => {
       
        status = response.status;
        
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
            message:e.message,
            data:{
                httpStatus: status
            }
        }
    });
}

window.util.getCart = ()=>{

}

window.util.cartQuantity = (qty)=>{

    qty = isNaN(qty) ? 0 : qty;
    
    Array.from(document.querySelectorAll('.cart-quantity')).map( item => {

        item.innerText = qty;
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



