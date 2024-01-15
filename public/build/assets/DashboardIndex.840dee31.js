import{c as i,a,b as f,e as d,d as s,t as e,s as n,F as u,n as v,o,H as x,f as m}from"./app.f33b5c0d.js";import{_}from"./PageTitle.dd8debfd.js";import{_ as g}from"./Breadcrumb.de4c8a73.js";const p={class:"px-4 grid sm:grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-4"},y={class:"stats shadow w-full border border-success overflow-hidden"},D={class:"stat"},I=s("div",{class:"stat-title"},"Pendapatan",-1),w={class:"stat-value text-success"},j=s("div",{class:"stat-desc mt-1"},"Total pemasukan bulan ini",-1),F=s("div",{class:"stat-actions flex justify-end hidden"},[s("button",{class:"btn btn-sm btn-success"},"Detail")],-1),N={class:"stats shadow w-full border border-error overflow-hidden"},P={class:"stat"},R=s("div",{class:"stat-title"},"Pengeluaran",-1),k={class:"stat-value"},B=s("div",{class:"stat-desc mt-1"},"Total pengeluaran bulan ini",-1),T=s("div",{class:"stat-actions flex justify-end hidden"},[s("button",{class:"btn btn-sm btn-error flex justify-end"},"Detail")],-1),V={class:"stat"},z=s("div",{class:"stat-title"},"Selisih Pendaptan / Pengeluaran",-1),C=s("div",{class:"stat-desc mt-1"},"Pendapatan / Pengeluaran bulan ini",-1),H={class:"stat-actions flex justify-end hidden"},L={class:"px-4 grid md:grid-cols-1 xl:grid-cols-3 gap-4"},S={class:"stats shadow w-full border border-error overflow-hidden"},$={class:"stat"},E=s("div",{class:"stat-title"},"Pinjaman",-1),O={class:"stat-value md:text-xl lg:text-3xl"},q=s("div",{class:"stat-actions flex justify-end hidden"},[s("button",{class:"btn btn-sm btn-error flex justify-end"},"Detail")],-1),A={class:"stat"},G={class:"stat-title"},J={class:"stat-value md:text-xl lg:text-3xl"},K=s("div",{class:"stat-actions flex justify-end hidden"},[s("button",{class:"btn btn-sm btn-error flex justify-end hidden"},"Detail")],-1),Z={__name:"DashboardIndex",props:{loan:Number,loans:Object,income:Number,expense:Number},setup(b){const t=b,h=[{url:null,label:"Dashboard"}];return(M,Q)=>{var c;return o(),i(u,null,[a(f(x),{title:"Dashboard"}),a(g,{links:h}),a(_,{classes:"bg-base-content",class:""},{default:d(()=>[m("Laba / Rugi")]),_:1}),s("section",p,[s("div",y,[s("div",D,[I,s("div",w,e(Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format(t.income)),1),j,F])]),s("div",N,[s("div",P,[R,s("div",k,e(Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format(t.expense)),1),B,T])]),s("div",{class:n(["stats shadow w-full border xl:col-span-1 overflow-hidden",t.income-t.expense<0?"border-error":"border-success"])},[s("div",V,[z,s("div",{class:n(["stat-value",t.income-t.expense<0?"text-error":"text-success"])},e(Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format(t.income-t.expense)),3),C,s("div",H,[s("button",{class:n(["btn btn-sm flex justify-end",t.income-t.expense<0?"btn-error ":"btn-success"])},"Detail",2)])])],2)]),a(_,{classes:"bg-base-content",class:""},{default:d(()=>[m("Pinjaman")]),_:1}),s("section",L,[s("div",S,[s("div",$,[E,s("div",O,e(Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format((c=t.loan)!=null?c:0)),1),q])]),s("div",{class:n(["stats shadow border stats-vertical lg:stats-horizontal border-error xl:col-span-2","lg:grid lg:grid-cols-"+t.loans.length])},[(o(!0),i(u,null,v(t.loans,(l,U)=>{var r;return o(),i("div",A,[s("div",G,"Pinjaman "+e(l.name),1),s("div",J,e(Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format((r=l.balance)!=null?r:0)),1),K])}),256))],2)])],64)}}};export{Z as default};