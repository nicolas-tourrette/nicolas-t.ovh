<template>
	<div class="container">
		<h1 class="ui header blue">
			<i class="icon newspaper outline"></i>
			<div class="content">
				Mes actualités
				<div class="sub header">Ici, je partage toutes mes actualités.</div>
			</div>
		</h1>
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
		<div class="ui divided items" v-if="news.length !== 0">
			<div class="item" :class="actu.category" v-for="actu in news" :key="actu.index">
				<div class="content">
					<span class="ui label yellow inverted" v-if="actu.important">
						<i class="icon exclamation triangle"></i>
					</span>
					<a class="header">{{ actu.title }}</a>
					<div class="meta">
						<div class="ui label" :class="actu.category === 'perso' ? 'ui purple' : 'ui red'">
							{{
								actu.category === "perso" ? (locale === 'fr' ? "Personnel" : "Personal") :
									(locale === 'fr' ? "Professionnel" : "Professional")
							}}
						</div>
						<span>
							<i class="ui icon calendar"></i>
							{{ locale === 'fr' ? "Publié par Nicolas TOURRETTE le" : "Published by Nicolas TOURRETTE on" }} {{ actu.date }}
						</span>
					</div>
					<div class="description">
						<p class="text-justify" v-for="content in actu.content" :key="content.index"
							v-html="content"></p>
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
</template>

<script>
export default {
	name: "Actualites",
	props: ['locale'],
	data: function () {
		return {
			news: []
		}
	},
	created() {
		this.getNews()
	},
	mounted: function () {
		this.displayTitle()
	},
	methods: {
		displayTitle: function () {
			if (this.locale === "fr") {
				document.title = `Accueil | ${this.$parent.$data.title}`
			} else {
				document.title = `Home | ${this.$parent.$data.title}`
			}
		},
		getNews: function () {
			$.ajax({
				url: `./assets/${this.locale}/news.json`,
				type: 'GET',
				dataType: "json",
				success: (response) => {
					this.news = response
				},
				error: (response, status, error) => {
					this.news = []
					throw new Error("Error when fetching the news: ", error)
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
		}
	},
	watch: {
		locale: function () {
			this.getNews()
			this.displayTitle()
		}
	}
}
</script>

<style scoped>
a.header {
	cursor: text !important;;
}

span.ui.yellow {
	margin-right: 10px;
}

span.ui.yellow i.icon {
	margin: 0 !important;
}

i.ui.icon.calendar {
	margin-left: 15px;
	margin-right: 3px !important;
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
</style>