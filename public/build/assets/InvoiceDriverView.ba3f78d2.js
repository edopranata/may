import{g as F,u as N,h as S,z as R,c as r,a as i,b as t,e as T,i as b,x as C,d as s,_ as m,f as _,w as j,y as f,t as l,j as d,F as g,n as P,s as y,G as V,o as a,H as U,Q as B,J as M,R as $,S as H}from"./app.f33b5c0d.js";import{_ as O}from"./Breadcrumb.de4c8a73.js";import{_ as z}from"./PageTitle.dd8debfd.js";import{s as x}from"./library.595eb791.js";const A={for:"modal-option",class:"modal cursor-pointer modal-lg"},K={class:"modal-box w-11/12 max-w-3xl",for:""},E={class:"flex justify-between"},G=["disabled"],J=["disabled"],L=["disabled"],Q={class:"px-6 w-full"},q={class:"card w-full rounded-none border-2 border-info shadow-xl"},W={class:"card-body"},X={class:"flex justify-between space-x-4 items-start"},Y={class:"grid md:grid-cols-2 gap-4 print:hidden"},Z={class:"form-control w-full col-span-2"},ss=s("label",{class:"label"},"No Nota / Invoice",-1),es={key:0,class:"label"},ts={class:"label-text-alt text-error"},os={class:"form-control w-full"},ns=s("label",{class:"label"},"Tanggal Nota / Invoice",-1),ls=["readonly"],rs={key:0,class:"label"},as={class:"label-text-alt text-error"},is={class:"form-control w-full"},ds=s("label",{class:"label"},"Upah Supir (Rp / Kg)",-1),cs={key:0,class:"label"},ps={class:"label-text-alt text-error"},us={class:"form-control w-full"},_s=s("label",{class:"label"},"Pinjaman",-1),bs={key:0,class:"label"},ms={class:"label-text-alt text-error"},xs={class:"form-control w-full"},vs=s("label",{class:"label"},"Angsuran Pinjaman",-1),hs={key:0,class:"label"},fs={class:"label-text-alt text-error"},gs={class:"flex justify-between col-span-2"},ys={class:"grid text-sm grid-cols-1 w-[50%] print:w-[100%]"},Is=V('<div class="grid grid-cols-5"><span class="font-bold text-center px-4 py-2 border-l border-y col-span-2">Tanggal / Keterangan</span><span class="font-bold text-center px-4 py-2 border-l border-y">Banyaknya</span><span class="font-bold text-center px-4 py-2 border-l border-y">Harga</span><span class="font-bold text-center px-4 py-2 border-x border-y">Total</span></div><div class="grid grid-cols-5"><span class="px-4 py-2 border-l font-bold col-span-2">Pembelian Sawit</span><span class="px-4 py-2 border-l"></span><span class="px-4 py-2 border-l"></span><span class="px-4 py-2 border-x"></span></div>',2),ws={class:"px-4 border-l col-span-2"},Ds={class:"px-4 border-l text-right"},ks={class:"px-4 border-l text-right"},Fs={class:"px-4 border-x text-right"},Ns=s("span",{class:"px-4 pb-4 border-l col-span-2"},null,-1),Ss=s("span",{class:"px-4 pb-4 border-l"},null,-1),Rs=s("span",{class:"px-4 pb-4 border-l"},null,-1),Ts={class:"px-4 pb-4 border-x text-right font-bold"},Cs={key:0,class:"grid grid-cols-5"},js=s("span",{class:"px-4 border-l font-bold col-span-2"},"Potongan",-1),Ps=s("span",{class:"px-4 border-l"},null,-1),Vs=s("span",{class:"px-4 border-l"},null,-1),Us=s("span",{class:"px-4 border-x text-right font-bold"},null,-1),Bs=[js,Ps,Vs,Us],Ms={key:1,class:"grid grid-cols-5"},$s=s("span",{class:"px-4 border-l col-span-2"},"Pinjaman Terakhir",-1),Hs=s("span",{class:"px-4 border-l"},null,-1),Os=s("span",{class:"px-4 border-l"},null,-1),zs={class:"px-4 border-x text-right font-bold"},As={key:2,class:"grid grid-cols-5"},Ks=s("span",{class:"px-4 border-l col-span-2"},"Bayar Pinjaman",-1),Es=s("span",{class:"px-4 border-l"},null,-1),Gs=s("span",{class:"px-4 border-l"},null,-1),Js={class:"px-4 border-x text-right"},Ls=s("span",{class:"px-4 border-l font-bold col-span-2"},"Sisa Pinjaman",-1),Qs=s("span",{class:"px-4 border-l"},null,-1),qs=s("span",{class:"px-4 border-l"},null,-1),Ws={class:"px-4 border-x text-right font-bold"},Xs={class:"grid grid-cols-5 border-b font-bold"},Ys=s("span",{class:"px-4 py-2 border-l text-right col-span-4"},"Total Diterima",-1),Zs={class:"px-4 py-2 border-x text-right"},le={__name:"InvoiceDriverView",props:{driver:Object},setup(I){const c=I,w=[{url:route("transaction.index"),label:"Transaksi"},{url:route("transaction.invoice.index"),label:"Invoice"},{url:route("transaction.invoice.driver.index"),label:"Invoice Supir"},{url:null,label:c.driver.name.toUpperCase()}],u=F(!1),e=N({print:!1,invoice_date:"",invoice_number:"OTOMATIS",driver_id:c.driver.id,trades:c.driver.trades,loan:c.driver.loan?c.driver.loan.balance:0,driver_fee:c.driver.price?c.driver.price.value:0,total:0,installment:0}),v=()=>{e.patch(route("transaction.invoice.driver.update",c.driver.id),{onFinish:()=>{u.value=!1}})},D=()=>{e.print=!1,v()},k=()=>{e.print=!0,v()};S(()=>{h()}),R(()=>H.cloneDeep(e),(p,o)=>{p.driver_fee&&h()});const h=()=>{let p=e.trades.reduce((o,n)=>(o.push(n.net_weight*e.driver_fee),o),[]);p=p.reduce((o,n)=>o+=n,0),e.total=p};return(p,o)=>(a(),r(g,null,[i(t(U),{title:"Invoice Supir"}),i(O,{links:w}),i(z,{classes:"bg-base-content",class:""},{default:T(()=>[_("Invoice Supir ")]),_:1}),b(s("input",{type:"checkbox",id:"modal-option","onUpdate:modelValue":o[0]||(o[0]=n=>u.value=n),class:"modal-toggle"},null,512),[[C,u.value]]),s("label",A,[s("label",K,[s("div",E,[s("button",{type:"button",disabled:t(e).processing,onClick:D,class:"btn btn-primary"},[i(m,{path:t(B)},null,8,["path"]),_(" Simpan")],8,G),s("button",{type:"button",disabled:t(e).processing,onClick:k,class:"btn btn-success"},[i(m,{path:t(M)},null,8,["path"]),_(" Simpan dan Print Invoice")],8,J),s("button",{type:"button",disabled:t(e).processing,onClick:o[1]||(o[1]=n=>u.value=!1),class:"btn btn-warning"},[i(m,{path:t($)},null,8,["path"]),_(" Batal")],8,L)])])]),s("section",Q,[s("div",q,[s("div",W,[s("div",X,[s("form",{onSubmit:o[8]||(o[8]=j(()=>{},["prevent"])),class:"w-[50%]"},[s("div",Y,[s("div",Z,[ss,b(s("input",{disabled:"","onUpdate:modelValue":o[2]||(o[2]=n=>t(e).invoice_number=n),type:"text",placeholder:"No Nota / Invoice",class:"input input-bordered w-full"},null,512),[[f,t(e).invoice_number]]),t(e).errors.invoice_number?(a(),r("label",es,[s("span",ts,l(t(e).errors.invoice_number),1)])):d("",!0)]),s("div",os,[ns,b(s("input",{readonly:t(e).processing,"onUpdate:modelValue":o[3]||(o[3]=n=>t(e).invoice_date=n),type:"date",placeholder:"Tanggal Nota / Invoice",class:"input input-bordered w-full"},null,8,ls),[[f,t(e).invoice_date]]),t(e).errors.invoice_date?(a(),r("label",rs,[s("span",as,l(t(e).errors.invoice_date),1)])):d("",!0)]),s("div",is,[ds,i(t(x),{options:{precision:0,prefix:"Rp ",isInteger:!0},readonly:t(e).processing,value:t(e).driver_fee,"onUpdate:value":o[4]||(o[4]=n=>t(e).driver_fee=n),class:"input input-bordered w-full"},null,8,["readonly","value"]),t(e).errors.driver_fee?(a(),r("label",cs,[s("span",ps,l(t(e).errors.driver_fee),1)])):d("",!0)]),s("div",us,[_s,i(t(x),{options:{precision:0,prefix:"Rp ",isInteger:!0},readonly:t(e).processing,value:t(e).loan,"onUpdate:value":o[5]||(o[5]=n=>t(e).loan=n),class:"input input-bordered w-full"},null,8,["readonly","value"]),t(e).errors.loan?(a(),r("label",bs,[s("span",ms,l(t(e).errors.loan),1)])):d("",!0)]),s("div",xs,[vs,i(t(x),{options:{precision:0,prefix:"Rp ",isInteger:!0},readonly:t(e).processing,value:t(e).installment,"onUpdate:value":o[6]||(o[6]=n=>t(e).installment=n),class:"input input-bordered w-full"},null,8,["readonly","value"]),t(e).errors.installment?(a(),r("label",hs,[s("span",fs,l(t(e).errors.installment),1)])):d("",!0)]),s("div",gs,[s("button",{type:"submit",onClick:o[7]||(o[7]=n=>u.value=!0),class:"btn btn-primary"},"Simpan")])])],32),s("div",ys,[Is,(a(!0),r(g,null,P(t(e).trades,(n,se)=>(a(),r("div",{class:"grid grid-cols-5",key:n.id},[s("span",ws,l(n.trade_date),1),s("span",Ds,l(Intl.NumberFormat("id-ID",{style:"unit",unit:"kilogram"}).format(n.net_weight)),1),s("span",ks,l(Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format(t(e).driver_fee)),1),s("span",Fs,l(Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format(n.net_weight*t(e).driver_fee)),1)]))),128)),s("div",{class:y(["grid grid-cols-5",t(e).loan?"":"border-b"])},[Ns,Ss,Rs,s("span",Ts,l(Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format(t(e).total)),1)],2),t(e).loan?(a(),r("div",Cs,Bs)):d("",!0),t(e).loan?(a(),r("div",Ms,[$s,Hs,Os,s("span",zs,l(Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format(t(e).loan)),1)])):d("",!0),t(e).loan?(a(),r("div",As,[Ks,Es,Gs,s("span",Js,l(Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format(t(e).installment?t(e).installment*-1:0)),1)])):d("",!0),t(e).loan?(a(),r("div",{key:3,class:y(["grid grid-cols-5",t(e).loan>1?"border-b":""])},[Ls,Qs,qs,s("span",Ws,l(Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format(t(e).loan-t(e).installment)),1)],2)):d("",!0),s("div",Xs,[Ys,s("span",Zs,l(Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format(t(e).total-t(e).installment)),1)])])])])])])],64))}};export{le as default};