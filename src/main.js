import Vue from "vue"
import VueRouter from "vue-router"
import VueI18n from "vue-i18n"
import App from "./App"
import Home from "./components/Home"
import Actualites from "./components/Actualites"
import Publications from "./components/Publications"
import Mariage from "./components/Mariage"
import CV from "./components/CV"
import CVHome from "./components/cv/Home"
import CVEducation from "./components/cv/Education"
import CVExperience from "./components/cv/Experience"
import CVSkills from "./components/cv/Skills"
import CVInterests from "./components/cv/Interests"
import CVProjects from "./components/cv/Projects"
import Informations from "./components/Informations"
import Landing from "./components/Landing"

import '../public/css/style.css'

Vue.config.productionTip = false

Vue.use(VueRouter)
Vue.use(VueI18n)

const router = new VueRouter({
    mode: 'hash',
    //base: __dirname,
    linkExactActiveClass: "active",
    linkActiveClass: "active",
    routes: [
        {
            path: '/home',
            name: "home",
            component: Home
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
            component: Mariage //Mariage,
        },
        {
            path: '/mariage/admin',
            name: "mariageadm",
            component: Landing,
        },
        {
            path: '/cv',
            component: CV,
            name: 'cv',
            redirect: {name: "cv-intro"},
            children: [
                {
                    path: 'intro',
                    name: 'cv-intro',
                    component: CVHome
                },
                {
                    path: 'education',
                    name: 'cv-education',
                    component: CVEducation
                },
                {
                    path: 'experience',
                    name: 'cv-experience',
                    component: CVExperience
                },
                {
                    path: 'skills',
                    name: 'cv-skills',
                    component: CVSkills
                },
                {
                    path: 'interests',
                    name: 'cv-interests',
                    component: CVInterests
                },
                {
                    path: 'projects',
                    name: 'cv-projects',
                    component: CVProjects
                }
            ]

        },
        {
            path: '/informations',
            name: "infos",
            component: Informations,
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
