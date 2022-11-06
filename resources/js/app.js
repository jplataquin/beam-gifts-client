import './bootstrap';



/** Feeze UI **/
/*




#The MIT License (MIT)

Copyright (c) 2017 Alex Radulescu

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

*/
(() => {

    /**
     * Setup the freeze element to be appended
     */
    let freezeHtml = document.createElement('div');
        freezeHtml.classList.add('freeze-ui');

    /** 
    * Freezes the UI
    * options = { 
    *   selector: '.class-name' -> Choose an element where to limit the freeze or leave empty to freeze the whole body. Make sure the element has position relative or absolute,
    *   text: 'Magic is happening' -> Choose any text to show or use the default "Loading". Be careful for long text as it will break the design.
    * }
    */
    window.FreezeUI = (options = {}) => {
        let parent = document.querySelector(options.selector) || document.body;
        freezeHtml.setAttribute('data-text', options.text || 'Loading');
        if (document.querySelector(options.selector)) {
            freezeHtml.style.position = 'absolute';
        }
        parent.appendChild(freezeHtml);
    };
    
    /**
     * Unfreezes the UI.
     * No options here.
     */
    window.UnFreezeUI = () => {
        let element = document.querySelector('.freeze-ui');
        if (element) {
 
           element.classList.add('is-unfreezing');
            setTimeout(() => {
                if (element) {
                    element.classList.remove('is-unfreezing');
                    element.parentElement.removeChild(element);
                }
            }, 250);
        }
    };

})();


window.util = {};

window.util.spaceToDash = (text) =>{

    return text.replace(/\s+/g," ").replace(/\s/g,'-');
}

window.util.$get = async (url,data) => {

    let status = '';
    
    return fetch(url+'?'+ new URLSearchParams(data),
    {
        headers: {
            "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').content,
            "Accept": "application/json"
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
        
        if(status == 401){
          
            return {
                    status:-1,
                    message:'Please sign in',
                    data:{}
            }
        };

        if(status == 500){

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

    return window.util.$post('/api/add-cart',formData);
}


window.util.removeFromCart = (data) =>{
    const formData = new FormData();

    formData.append('id',data.id)

    return window.util.$post('/api/remove-cart',formData);
}

window.util.updateCart = (data) =>{

}


window.util.clearCart = (data) =>{

}


window.util.moneyFormat = (currency,number) => {

    return currency.toUpperCase()+' '+number.toLocaleString('en-US', {maximumFractionDigits:2});
} 
