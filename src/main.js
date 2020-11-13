import Vue from 'vue'
import VueRouter from 'vue-router'
import VueI18n from 'vue-i18n'
import App from './App'
import HelloWorld from "./components/Home"
import Actualites from "./components/Actualites"
import Publications from "./components/Publications"

import '../public/css/style.css'

Vue.config.productionTip = false

Vue.use(VueRouter)
Vue.use(VueI18n)

const router = new VueRouter({
	mode: 'hash',
	base: __dirname,
	linkExactActiveClass: "active",
	linkActiveClass: "active",
	routes: [
		{
			path: '/home',
			name: "home",
			component: HelloWorld
		},
		{
			path: '/actualites',
			name: "news",
			component: Actualites
		},
		{
			path: '/publications',
			name: "publications",
			component: Publications,
			children: [
				{
					path: ':pid',
					name: "publication-detail",
					component: Publications
				}
			]
		},
		{
			path: '/mariage',
			name: "mariage",
		},
		{
			path: '/cv',
			name: "cv",
		},
		{
			path: '*',
			redirect: {name: "home"}
		}
	]
})

function loadLocaleMessages() {
	const locales = require.context('./locales', true, /[A-Za-z0-9-_,\s]+\.json$/i)
	const messages = {}
	locales.keys().forEach(key => {
		const matched = key.match(/([A-Za-z0-9-_]+)\./i)
		if (matched && matched.length > 1) {
			const locale = matched[1]
			messages[locale] = locales(key)
		}
	})
	return messages
}

export const i18n = new VueI18n({
	locale: navigator.language.substring(0, 2),
	fallbackLocale: 'en',
	messages: loadLocaleMessages()
})

new Vue({
	router: router,
	i18n: i18n,
	render: h => h(App),
}).$mount('#app')
