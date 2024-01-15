import{g as R,u as T,h as P,z as S,c as i,a as d,b as t,e as y,i as m,x as C,d as s,_,f as p,w as V,y as g,t as a,j as c,s as f,F as I,n as B,k as D,G,o as n,H as U,Q as $,J as K,R as M,q as O,L as A,S as H}from"./app.f33b5c0d.js";import{_ as L}from"./Breadcrumb.de4c8a73.js";import{_ as z}from"./PageTitle.dd8debfd.js";import{_ as q}from"./Pagination.e303f81d.js";import{s as h}from"./library.595eb791.js";const E={for:"modal-option",class:"modal cursor-pointer modal-lg"},J={class:"modal-box w-11/12 max-w-3xl",for:""},Q={class:"flex justify-between"},W=["disabled"],X=["disabled"],Y=["disabled"],Z={class:"px-6 w-full"},ss={class:"card w-full rounded-none border-2 border-info shadow-xl"},ts={class:"card-body"},es={class:"flex justify-between space-x-4 items-start"},os={class:"grid md:grid-cols-2 gap-4 print:hidden"},as={class:"form-control w-full col-span-2"},rs=s("label",{class:"label"},"No Nota / Invoice",-1),ns={key:0,class:"label"},ls={class:"label-text-alt text-error"},is={class:"form-control w-full"},cs=s("label",{class:"label"},"Tanggal Nota / Invoice",-1),ds=["readonly"],ps={key:0,class:"label"},us={class:"label-text-alt text-error"},_s={class:"form-control w-full"},bs=s("label",{class:"label"},"Gaji Karyawan",-1),ms={key:0,class:"label"},hs={class:"label-text-alt text-error"},xs={class:"form-control w-full"},vs=s("label",{class:"label"},"Pinjaman",-1),ys={key:0,class:"label"},gs={class:"label-text-alt text-error"},fs={class:"form-control w-full"},Is=s("label",{class:"label"},"Angsuran Pinjaman",-1),Ds={key:0,class:"label"},ws={class:"label-text-alt text-error"},ks={class:"flex justify-between col-span-2"},Fs={class:"grid text-sm grid-cols-1 w-[50%] print:w-[100%]"},Ns=G('<div class="grid grid-cols-5"><span class="font-bold text-center px-4 py-2 border-l border-y col-span-2">Tanggal / Keterangan</span><span class="font-bold text-center px-4 py-2 border-l border-y">Banyaknya</span><span class="font-bold text-center px-4 py-2 border-l border-y">Harga</span><span class="font-bold text-center px-4 py-2 border-x border-y">Total</span></div><div class="grid grid-cols-5"><span class="px-4 py-2 border-l font-bold col-span-2">Pembayaran Gaji</span><span class="px-4 py-2 border-l"></span><span class="px-4 py-2 border-l"></span><span class="px-4 py-2 border-x"></span></div>',2),js={class:"grid grid-cols-5"},Rs={class:"px-4 border-l col-span-2"},Ts=s("span",{class:"px-4 border-l text-right"},null,-1),Ps={class:"px-4 border-l text-right"},Ss={class:"px-4 border-x text-right"},Cs=s("span",{class:"px-4 pb-4 border-l col-span-2"},null,-1),Vs=s("span",{class:"px-4 pb-4 border-l"},null,-1),Bs=s("span",{class:"px-4 pb-4 border-l"},null,-1),Gs={class:"px-4 pb-4 border-x text-right font-bold"},Us={key:0,class:"grid grid-cols-5"},$s=s("span",{class:"px-4 border-l font-bold col-span-2"},"Potongan",-1),Ks=s("span",{class:"px-4 border-l"},null,-1),Ms=s("span",{class:"px-4 border-l"},null,-1),Os=s("span",{class:"px-4 border-x text-right font-bold"},null,-1),As=[$s,Ks,Ms,Os],Hs={key:1,class:"grid grid-cols-5"},Ls=s("span",{class:"px-4 border-l col-span-2"},"Pinjaman Terakhir",-1),zs=s("span",{class:"px-4 border-l"},null,-1),qs=s("span",{class:"px-4 border-l"},null,-1),Es={class:"px-4 border-x text-right font-bold"},Js={key:2,class:"grid grid-cols-5"},Qs=s("span",{class:"px-4 border-l col-span-2"},"Bayar Pinjaman",-1),Ws=s("span",{class:"px-4 border-l"},null,-1),Xs=s("span",{class:"px-4 border-l"},null,-1),Ys={class:"px-4 border-x text-right"},Zs=s("span",{class:"px-4 border-l font-bold col-span-2"},"Sisa Pinjaman",-1),st=s("span",{class:"px-4 border-l"},null,-1),tt=s("span",{class:"px-4 border-l"},null,-1),et={class:"px-4 border-x text-right font-bold"},ot={class:"grid grid-cols-5 border-y font-bold"},at=s("span",{class:"px-4 py-2 border-l text-right col-span-4"},"Total Diterima",-1),rt={class:"px-4 py-2 border-x text-right"},nt={class:"card-body"},lt={class:"w-full text-left text-base"},it=s("thead",{class:"text-sm uppercase bg-primary/20"},[s("tr",null,[s("th",{class:"py-3 px-6"},"#"),s("th",{class:"py-3 px-6"},"Invoice Number"),s("th",{class:"py-3 px-6"},"Nama"),s("th",{class:"py-3 px-6 text-right"},"Total"),s("th",{class:"py-3 px-6 text-right"},"Pinjaman"),s("th",{class:"py-3 px-6 text-right"},"Bayar Pinjaman"),s("th",{class:"py-3 px-6 text-right"},"Diterima"),s("th",{class:"py-3 px-6"})])],-1),ct={class:"hover:cursor-pointer group border-b"},dt={class:"group-hover:bg-base-300 py-4 px-6"},pt={class:"group-hover:bg-base-300 py-4 px-6"},ut={class:"font-bold"},_t={class:"text-sm opacity-50"},bt={class:"group-hover:bg-base-300 py-4 px-6"},mt={class:"font-bold"},ht={class:"text-sm opacity-50"},xt={class:"group-hover:bg-base-300 py-4 px-6 text-right"},vt={class:"group-hover:bg-base-300 py-4 px-6 text-right"},yt={class:"group-hover:bg-base-300 py-4 px-6 text-right"},gt={class:"group-hover:bg-base-300 py-4 px-6 text-right"},ft={class:"group-hover:bg-base-300 py-4 px-6"},It={key:1},Dt={colspan:"8",class:"text-center border-b-2"},Rt={__name:"InvoiceSupervisorView",props:{supervisor:Object,invoices:Object},setup(w){const l=w,k=[{url:route("transaction.index"),label:"Transaksi"},{url:route("transaction.invoice.index"),label:"Invoice"},{url:route("transaction.invoice.supervisor.index"),label:"Gaji Karyawan"},{url:null,label:l.supervisor.name}],u=R(!1),e=T({print:!1,invoice_date:"",invoice_number:"OTOMATIS",supervisor_id:l.supervisor.id,supervisor_fee:l.supervisor.price?l.supervisor.price.value:0,loan:l.supervisor.loan?l.supervisor.loan.balance:0,total:0,installment:0}),x=()=>{e.patch(route("transaction.invoice.supervisor.update",l.supervisor.id),{onFinish:()=>{u.value=!1}})},F=()=>{e.print=!1,x()},N=()=>{e.print=!0,x()};P(()=>{v()}),S(()=>H.cloneDeep(e),(b,r)=>{b.supervisor_fee&&v()});const v=()=>{e.total=e.supervisor_fee};return(b,r)=>(n(),i(I,null,[d(t(U),{title:"Gaji Karyawan"}),d(L,{links:k}),d(z,{classes:"bg-base-content",class:""},{default:y(()=>[p("Gaji Karyawan ")]),_:1}),m(s("input",{type:"checkbox",id:"modal-option","onUpdate:modelValue":r[0]||(r[0]=o=>u.value=o),class:"modal-toggle"},null,512),[[C,u.value]]),s("label",E,[s("label",J,[s("div",Q,[s("button",{type:"button",disabled:t(e).processing,onClick:F,class:"btn btn-primary"},[d(_,{path:t($)},null,8,["path"]),p(" Simpan")],8,W),s("button",{type:"button",disabled:t(e).processing,onClick:N,class:"btn btn-success"},[d(_,{path:t(K)},null,8,["path"]),p(" Simpan dan Print Invoice")],8,X),s("button",{type:"button",disabled:t(e).processing,onClick:r[1]||(r[1]=o=>u.value=!1),class:"btn btn-warning"},[d(_,{path:t(M)},null,8,["path"]),p(" Batal")],8,Y)])])]),s("section",Z,[s("div",ss,[s("div",ts,[s("div",es,[s("form",{onSubmit:r[8]||(r[8]=V(()=>{},["prevent"])),class:"w-[50%]"},[s("div",os,[s("div",as,[rs,m(s("input",{disabled:"","onUpdate:modelValue":r[2]||(r[2]=o=>t(e).invoice_number=o),type:"text",placeholder:"No Nota / Invoice",class:"input input-bordered w-full"},null,512),[[g,t(e).invoice_number]]),t(e).errors.invoice_number?(n(),i("label",ns,[s("span",ls,a(t(e).errors.invoice_number),1)])):c("",!0)]),s("div",is,[cs,m(s("input",{readonly:t(e).processing,"onUpdate:modelValue":r[3]||(r[3]=o=>t(e).invoice_date=o),type:"date",placeholder:"Tanggal Nota / Invoice",class:"input input-bordered w-full"},null,8,ds),[[g,t(e).invoice_date]]),t(e).errors.invoice_date?(n(),i("label",ps,[s("span",us,a(t(e).errors.invoice_date),1)])):c("",!0)]),s("div",_s,[bs,d(t(h),{options:{precision:0,prefix:"Rp ",isInteger:!0},readonly:t(e).processing,value:t(e).supervisor_fee,"onUpdate:value":r[4]||(r[4]=o=>t(e).supervisor_fee=o),class:"input input-bordered w-full"},null,8,["readonly","value"]),t(e).errors.supervisor_fee?(n(),i("label",ms,[s("span",hs,a(t(e).errors.supervisor_fee),1)])):c("",!0)]),s("div",xs,[vs,d(t(h),{options:{precision:0,prefix:"Rp ",isInteger:!0},readonly:t(e).processing,value:t(e).loan,"onUpdate:value":r[5]||(r[5]=o=>t(e).loan=o),class:"input input-bordered w-full"},null,8,["readonly","value"]),t(e).errors.loan?(n(),i("label",ys,[s("span",gs,a(t(e).errors.loan),1)])):c("",!0)]),s("div",fs,[Is,d(t(h),{options:{precision:0,prefix:"Rp ",isInteger:!0},readonly:t(e).processing,value:t(e).installment,"onUpdate:value":r[6]||(r[6]=o=>t(e).installment=o),class:"input input-bordered w-full"},null,8,["readonly","value"]),t(e).errors.installment?(n(),i("label",Ds,[s("span",ws,a(t(e).errors.installment),1)])):c("",!0)]),s("div",ks,[s("button",{type:"submit",onClick:r[7]||(r[7]=o=>u.value=!0),class:"btn btn-primary"},"Simpan")])])],32),s("div",Fs,[Ns,s("div",js,[s("span",Rs,a(t(e).invoice_date),1),Ts,s("span",Ps,a(Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format(t(e).supervisor_fee)),1),s("span",Ss,a(Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format(t(e).supervisor_fee)),1)]),s("div",{class:f(["grid grid-cols-5",t(e).loan?"":"border-b"])},[Cs,Vs,Bs,s("span",Gs,a(Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format(t(e).total)),1)],2),t(e).loan?(n(),i("div",Us,As)):c("",!0),t(e).loan?(n(),i("div",Hs,[Ls,zs,qs,s("span",Es,a(Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format(t(e).loan)),1)])):c("",!0),t(e).loan?(n(),i("div",Js,[Qs,Ws,Xs,s("span",Ys,a(Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format(t(e).installment?t(e).installment*-1:0)),1)])):c("",!0),t(e).loan?(n(),i("div",{key:3,class:f(["grid grid-cols-5",t(e).loan>1?"border-b":""])},[Zs,st,tt,s("span",et,a(Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format(t(e).loan-t(e).installment)),1)],2)):c("",!0),s("div",ot,[at,s("span",rt,a(Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format(t(e).supervisor_fee-t(e).installment)),1)])])])]),s("div",nt,[s("table",lt,[it,s("tbody",null,[l.invoices.data.length?(n(!0),i(I,{key:0},B(l.invoices.data,(o,j)=>(n(),i("tr",ct,[s("th",dt,a(l.invoices.from+j),1),s("td",pt,[s("div",null,[s("div",ut,a(o.invoice_number),1),s("div",_t,a(o.invoice_date),1)])]),s("td",bt,[s("div",null,[s("div",mt,a(o.modelable?o.modelable.name:""),1),s("div",ht,a(o.modelable?o.modelable.phone:""),1)])]),s("td",xt,a(Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format(o.total_buy)),1),s("td",vt,a(Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format(o.loan)),1),s("td",yt,a(Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format(o.loan_installment)),1),s("td",gt,a(Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format(o.total)),1),s("td",ft,[d(_,{path:t(O)},null,8,["path"])])]))),256)):(n(),i("tr",It,[s("td",Dt,[p("No Data "),l.invoices.current_page>1?(n(),D(t(A),{key:0,class:"link link-primary",href:b.route("report.invoice.search.index")},{default:y(()=>[p("Goto First Page")]),_:1},8,["href"])):c("",!0)])]))])]),l.invoices.data.length?(n(),D(q,{key:0,links:l.invoices.links},null,8,["links"])):c("",!0)])])])],64))}};export{Rt as default};