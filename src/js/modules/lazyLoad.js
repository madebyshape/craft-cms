import LazyLoad from "vanilla-lazyload";

const lazyLoadModule = () => { 

   new LazyLoad(
      { 
         elements_selector: '.js-lazy-load'
      }
   );
    
}
   
export { lazyLoadModule };