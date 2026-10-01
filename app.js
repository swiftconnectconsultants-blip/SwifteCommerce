async function cartAction(action,id=null,qty=1){
 const fd=new FormData();fd.append('action',action);if(id!==null)fd.append('id',id);fd.append('qty',qty);
 const r=await fetch(window.BASE_URL+'/api/cart.php',{method:'POST',body:fd});return r.json();
}
document.addEventListener('click',async e=>{
 const add=e.target.closest('[data-add]'); if(add){const qty=document.querySelector('#qty')?.value||1;const r=await cartAction('add',add.dataset.add,qty);if(r.ok){document.querySelector('#cartCount').textContent=r.count;add.textContent='Added ✓';setTimeout(()=>add.textContent='Add to bag',1200);}}
 const rem=e.target.closest('[data-remove]');if(rem){await cartAction('remove',rem.dataset.remove);location.reload();}
});
document.querySelectorAll('.cart-qty').forEach(x=>x.addEventListener('change',async()=>{await cartAction('set',x.dataset.id,x.value);location.reload();}));
