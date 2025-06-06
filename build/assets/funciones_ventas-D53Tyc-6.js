let a=1,u=[],f={},s=0;document.addEventListener("DOMContentLoaded",function(){document.querySelector("#productosTable tbody").addEventListener("change",function(e){e.target&&e.target.matches('select[name^="productos"]')&&q(e)}),document.querySelectorAll(".btn-crear").forEach(e=>{e.addEventListener("click",async function(){try{u=await(await fetch("/productos/lista")).json(),u.forEach(n=>{f[n.id_producto]=n}),S()}catch(c){console.error("Error cargando productos:",c)}})}),document.querySelectorAll(".btn-editar").forEach(e=>{e.addEventListener("click",async function(){const c=this.dataset.id,n=document.querySelector("#tablaDetalles tbody");n.innerHTML="",a=0;try{u=await(await fetch("/productos/lista")).json(),u.forEach(r=>{f[r.id_producto]=r}),(await(await fetch(`/ventas/detalles/${c}`)).json()).forEach(r=>{const d=document.createElement("tr");let g='<option value="">Producto</option>';u.forEach(b=>{const _=b.id_producto==r.id_prd?"selected":"";g+=`<option value="${b.id_producto}" ${_}>${b.nombre_producto}</option>`}),d.innerHTML=`
            <td>
              <select class="form form-control" name="productos[${a}][id_producto]" required>
                ${g}
              </select>
            </td>
            <td><input type="number" class="form form-control" value="${r.cantidad}" name="productos[${a}][cantidad]" required></td>
            <td><input type="number" class="form form-control" step="0.01" value="${r.precio_venta}" name="productos[${a}][precio_venta]" readonly></td>
            <td><input type="number" class="form form-control" step="0.01" value="${r.subtotal}" name="productos[${a}][subtotal]" readonly></td>
            <td><input type="number" class="form form-control" step="0.01" value="${r.IVA}" name="productos[${a}][IVA]" readonly></td>
            <td><input type="number" class="form form-control" step="0.01" value="${r.total}" name="productos[${a}][total]" readonly></td>
            <td><button type="button" class="btn btn-primary btn-eliminar-filaDetalles">X</button></td> 
          `,d.querySelector(".btn-eliminar-filaDetalles").addEventListener("click",function(){v(this,()=>{d.remove(),y()})}),d.querySelector('input[name$="[cantidad]"]').addEventListener("input",()=>{p(d)}),n.appendChild(d),p(d),a++}),n.addEventListener("change",function(r){r.target&&r.target.matches('select[name^="productos"]')&&q(r)});const l=this.closest("tr").querySelectorAll("td");document.getElementById("editar_id").value=l[0].textContent.trim(),document.getElementById("editar_cliente").value=l[1].dataset.id,document.getElementById("editar_usuario").value=l[2].dataset.id,document.getElementById("editar_fecha_venta").value=l[3].textContent.trim(),document.getElementById("editar_total").value=l[5].textContent.trim(),document.getElementById("formActualizarVenta").action=`/ventas/actualizar/${c}`}catch(i){console.error("Error cargando productos o detalles:",i)}})});const o=document.querySelector("[data-agregar-filaDetalles]");o&&o.addEventListener("click",D);const t=document.querySelector("[data-agregar-fila]");t&&t.addEventListener("click",S)});function h(){return u.map(o=>`<option value="${o.id_producto}">${o.nombre_producto}</option>`).join("")}function q(o){const t=o.target,e=t.value,c=t.closest("tr"),n=c.querySelector('input[name$="[precio_venta]"]');if(!e||!f[e]){n.value="",p(c);return}const i=parseFloat(f[e].precio_venta);n.value=i.toFixed(2),p(c)}function y(){let o=0;document.querySelectorAll("#tablaDetalles tbody tr, #productosTable tbody tr").forEach(c=>{const n=c.querySelector('input[name$="[total]"]');o+=parseFloat(n==null?void 0:n.value)||0});const t=document.getElementById("editar_total"),e=document.getElementById("total");t&&(t.value=o.toFixed(2)),e&&(e.value=o.toFixed(2))}function p(o){const t=o.querySelector('input[name$="[cantidad]"]'),e=o.querySelector('input[name$="[precio_venta]"]'),c=o.querySelector('input[name$="[subtotal]"]'),n=o.querySelector('input[name$="[IVA]"]'),i=o.querySelector('input[name$="[total]"]'),$=parseFloat(t==null?void 0:t.value)||0,E=parseFloat(e==null?void 0:e.value)||0,m=$*E,l=m*.16,r=m+l;c.value=m.toFixed(2),n.value=l.toFixed(2),i.value=r.toFixed(2),y()}function v(o,t){Swal.fire({title:"¿Estás seguro de eliminar el producto?",text:"No podrás revertir esto",icon:"warning",showCancelButton:!0,confirmButtonText:"Sí, eliminar",cancelButtonText:"Cancelar"}).then(e=>{e.isConfirmed&&(t(),Swal.fire("Eliminado","El producto ha sido eliminado.","success"))})}function S(){const t=document.querySelector("#productosTable tbody").insertRow();t.innerHTML=`
    <td>
      <select class="form form-control" name="productos[${s}][id_producto]" required>
        <option value="">Producto</option>
        ${h()}
      </select>
    </td>
    <td><input type="number" class="form form-control" name="productos[${s}][cantidad]" required></td>
    <td><input type="number" class="form form-control" step="0.01" name="productos[${s}][precio_venta]" readonly></td>
    <td><input type="number" class="form form-control" step="0.01" name="productos[${s}][subtotal]" readonly></td>
    <td><input type="number" class="form form-control" step="0.01" name="productos[${s}][IVA]" readonly></td>
    <td><input type="number" class="form form-control" step="0.01" name="productos[${s}][total]" readonly></td>
    <td><button type="button" class="btn btn-primary btn-eliminar-fila">X</button></td>
  `,t.querySelector(".btn-eliminar-fila").addEventListener("click",function(){v(this,()=>{t.remove(),y()})}),t.querySelector('input[name$="[cantidad]"]').addEventListener("input",()=>{p(t)}),s++}function D(){const t=document.querySelector("#tablaDetalles tbody").insertRow(),e=h();t.innerHTML=`
    <td>
      <select class="form form-control" name="productos[${a}][id_producto]" required>
        <option value="">Producto</option>
        ${e}
      </select>
    </td>
    <td><input type="number" class="form form-control" name="productos[${a}][cantidad]" required></td>
    <td><input type="number" class="form form-control" step="0.01" name="productos[${a}][precio_venta]" readonly></td>
    <td><input type="number" class="form form-control" step="0.01" name="productos[${a}][subtotal]" readonly></td>
    <td><input type="number" class="form form-control" step="0.01" name="productos[${a}][IVA]"  readonly></td>
    <td><input type="number" class="form form-control" step="0.01" name="productos[${a}][total]"  readonly></td>
    <td><button type="button" class="btn btn-primary btn-eliminar-filaDetalles">X</button></td>
  `,t.querySelector(".btn-eliminar-filaDetalles").addEventListener("click",function(){v(this,()=>{t.remove(),y()})}),t.querySelector('input[name$="[cantidad]"]').addEventListener("input",()=>{p(t)}),a++}
