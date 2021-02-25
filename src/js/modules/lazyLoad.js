import LazyLoad from "vanilla-lazyload";

const lazyLoadModule = () => { 

   new LazyLoad(
      { 
         elements_selector: '.js-lazy-load',
         class_loaded: 'lazy-load--loaded',
         threshold: (window.innerHeight / 5)
      }
   );
    
}
   
export { lazyLoadModule };
