<template>
	<div class="container">
		<h1 class="ui header blue">
			<i class="icon newspaper outline"></i>
			<div class="content">
				Mes publications
				<div class="sub header">Ici, je partage toutes mes publications académiques, personnelles ou professionnelles.</div>
			</div>
		</h1>
		<div v-if="$route.params.pid !== undefined" style="height: calc(100% - 50px);">
			<h2>{{ this.currentTitle }}</h2>
			<iframe class="reading-box" :src="`./assets/${locale}/articles/article-${$route.params.pid}.pdf`"></iframe>
		</div>
		<div v-else>
			<div class="ui basic segment center aligned">
				<button class="ui small button" @click="displayAll()">
					{{ this.locale === 'fr' ? "Tout afficher" : "Display all" }}
				</button>
				<button class="ui small button red" @click="displaySome('pro')">
					{{ this.locale === 'fr' ? "Professionnel" : "Professional" }}
				</button>
				<button class="ui small button purple" @click="displaySome('perso')">
					{{ this.locale === 'fr' ? "Personnel" : "Personal" }}
				</button>
			</div>
			<div class="ui divided items" v-if="publications.length !== 0">
				<div class="item" :class="publi.category" v-for="publi in publications" :key="publi.index">
					<div class="image">
						<img class="ui rounded image" :src="require('../assets/img/publications/' + (publi.thumbnail !== undefined ? publi.thumbnail !==
					'' ? publi.thumbnail :
					'article.jpg' : 'article.jpg'))">
					</div>
					<div class="content">
						<a class="header">{{ publi.title }}</a>
						<div class="meta">
							<div class="ui label" :class="publi.category === 'perso' ? 'ui purple' : 'ui red'">
								{{
									publi.category === "perso" ? (locale === 'fr' ? "Personnel" : "Personal") :
										(locale === 'fr' ? "Professionnel" : "Professional")
								}}
							</div>
							<span>
							<i class="ui icon calendar"></i>
							{{ locale === 'fr' ? "Publié par Nicolas TOURRETTE le" : "Published by Nicolas TOURRETTE on" }} {{ publi.date }}
						</span>
							<div class="extra">
								<i class="icon tags"></i> <div class="ui label" v-for="keyword in publi.keywords" :key="keyword.key">{{
									keyword }}</div>
							</div>
						</div>
						<div class="description">
							<p class="justified" v-html="publi.abstract"></p>
						</div>
						<div class="extra">
							<router-link class="ui primary button" :to="{ name: 'publication-detail', params:{ pid: publi.link.substring(8) } }">
								<i class="icon file alternate"></i> Lire la publication
							</router-link>
						</div>
					</div>
				</div>
				<div class="ui placeholder segment hidden">
					<div class="ui icon header">
						<i class="search icon"></i>
						{{ this.locale === 'fr' ? "Il n'y a rien ici..." : "There is nothing here..." }}
					</div>
				</div>
			</div>
			<div v-else>
				<div class="ui placeholder segment">
					<div class="ui icon header">
						<i class="search icon"></i>
						{{ this.locale === 'fr' ? "Il n'y a rien ici..." : "There is nothing here..." }}
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	name: "Publications.vue",
	props: ['locale'],
	data: function () {
		return {
			publications: [],
			currentTitle: ""
		}
	},
	created() {
		this.getPublications()
	},
	mounted: function () {
		document.title = `Publications | ${this.$parent.$data.title}`
	},
	updated() {
		this.getPublicationTitle()
	},
	methods: {
		getPublications: function () {
			$.ajax({
				url: `./assets/${this.locale}/publications.json`,
				type: 'GET',
				dataType: "json",
				success: (response) => {
					this.publications = response
				},
				error: (response, status, error) => {
					this.publications = []
					throw new Error("Error when fetching the publications: ", error)
				}
			})
		},
		displayAll: () => {
			document.querySelector(".ui.placeholder.segment").classList.add("hidden")
			document.querySelectorAll("div.ui.divided.items .item").forEach((item) => {
				item.classList.remove("hidden", "first")
				item.classList.add("visible")
			})
		},
		displaySome: function (toDisplay) {
			this.displayAll()
			try {
				document.querySelectorAll(`div.ui.divided.items .item.${toDisplay}`)[0].classList.add("first")
			} catch (e) {
				document.querySelector(".ui.placeholder.segment.hidden").classList.remove("hidden")
				console.warn(`No news to display in category ${toDisplay}`)
			}
			document.querySelectorAll(`div.ui.divided.items .item:not(.${toDisplay})`).forEach((item) => {
				item.classList.remove("visible")
				item.classList.add("hidden")
			})
		},
		getPublicationTitle: function () {
			let params = this.$route.params
			if (params !== undefined && this.publications.length > 0) {
				if (params.pid !== undefined) {
					this.publications.some((publication) => {
						if (publication.link === `article-${params.pid}`) {
							this.currentTitle = publication.title
							return true
						}
					})
					if (this.currentTitle === "") {
						console.warn(`No publication found for id ${params.pid}.`)
					}
				}
			}
		}
	},
	watch: {
		locale: function () {
			this.getPublications()
		}
	}
}
</script>

<style scoped>
.container {
	height: calc(100% - 50px);
}

a.header {
	cursor: text !important;;
}

i.ui.icon.calendar {
	margin-left: 15px;
	margin-right: 3px !important;
}

img.ui.rounded.image {
	border-radius: .5em !important;
}

.justified {
	text-align: justify;
}

.ui.placeholder:not(.hidden) {
	visibility: visible;
	opacity: 1;
	transition: opacity .3s linear .3s !important;
}

.ui.placeholder.hidden {
	visibility: hidden;
	opacity: 0;
	transition: visibility 0s .3s, opacity .3s linear !important;
	height: 0 !important;
	min-height: 0 !important;
	padding: 0 !important;
}

.visible {
	visibility: visible;
	opacity: 1;
	transition: opacity .3s linear !important;
}

.hidden {
	visibility: hidden;
	opacity: 0;
	transition: visibility 0s .3s, opacity .3s linear !important;
	height: 0 !important;
	min-height: 0 !important;
	padding: 0 !important;
}

.ui.divided.items .item.hidden {
	border-top: 0 !important;
}

.ui.divided.items .item.visible.first {
	border-top: 0 !important;
	padding-top: 0 !important;
}

button {
	transition: transform .3s !important;
}

button:hover {
	transform: scale(.95);
}

.reading-box {
	width: 100%;
	height: calc(100% - 50px);
	border-width: 0px;
}
</style>