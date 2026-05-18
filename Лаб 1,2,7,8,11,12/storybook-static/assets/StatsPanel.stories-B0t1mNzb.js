import{j as e}from"./jsx-runtime-CDt2p4po.js";import"./index-GiUgBvb1.js";const b=({items:v})=>e.jsx("div",{className:"stats",children:v.map(r=>e.jsxs("article",{className:"stat-card",children:[e.jsx("p",{className:"stat-card__label",children:r.label}),e.jsx("p",{className:"stat-card__value",children:r.value})]},r.label))});b.__docgenInfo={description:`Displays a row of statistic cards (label + value pairs).\r
@param {Object} props\r
@param {Array<{ label: string, value: string|number }>} props.items - Metrics to render.\r
@returns {JSX.Element}\r
@example\r
<StatsPanel items={[{ label: "Ходи", value: 12 }, { label: "Час", value: "01:23" }]} />`,methods:[],displayName:"StatsPanel"};const x={title:"Components/StatsPanel",component:b,tags:["autodocs"],parameters:{docs:{description:{component:"Базовий компонент для відображення метрик гри у вигляді карток."}}},argTypes:{items:{description:"Масив метрик { label, value }",control:"object"}}},a={args:{items:[{label:"Ходи",value:8},{label:"Збігів",value:3},{label:"Час",value:"01:24"}]}},s={args:{items:[{label:"Останній час",value:"--:--"},{label:"Останні ходи",value:"--"},{label:"Точність",value:"--"}]}},l={args:{items:[{label:"Рекорд",value:"00:42"}]}};var t,n,o;a.parameters={...a.parameters,docs:{...(t=a.parameters)==null?void 0:t.docs,source:{originalSource:`{
  args: {
    items: [{
      label: "Ходи",
      value: 8
    }, {
      label: "Збігів",
      value: 3
    }, {
      label: "Час",
      value: "01:24"
    }]
  }
}`,...(o=(n=a.parameters)==null?void 0:n.docs)==null?void 0:o.source}}};var c,m,i;s.parameters={...s.parameters,docs:{...(c=s.parameters)==null?void 0:c.docs,source:{originalSource:`{
  args: {
    items: [{
      label: "Останній час",
      value: "--:--"
    }, {
      label: "Останні ходи",
      value: "--"
    }, {
      label: "Точність",
      value: "--"
    }]
  }
}`,...(i=(m=s.parameters)==null?void 0:m.docs)==null?void 0:i.source}}};var p,u,d;l.parameters={...l.parameters,docs:{...(p=l.parameters)==null?void 0:p.docs,source:{originalSource:`{
  args: {
    items: [{
      label: "Рекорд",
      value: "00:42"
    }]
  }
}`,...(d=(u=l.parameters)==null?void 0:u.docs)==null?void 0:d.source}}};const j=["Default","EmptyValues","SingleMetric"];export{a as Default,s as EmptyValues,l as SingleMetric,j as __namedExportsOrder,x as default};
