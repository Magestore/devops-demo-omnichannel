/*
 *  Copyright © 2016 Magestore. All rights reserved.
 *  See COPYING.txt for license details.
 *
 */

define(
    [
        'Magestore_Webpos/js/model/factory',
        'Magestore_Webpos/js/model/catalog/product/type/storecredit',
    ],
    function(Factory, ModelClass){
         "use strict";
        return {
            get: function(){
                var key = 'model/catalog/product/type/storecredit';
                return Factory.getSingleton(key, ModelClass);              
            },
            
            create: function(){
                return ModelClass();
            }
        }
    }
);