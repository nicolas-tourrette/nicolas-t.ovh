<template>
	<div>
		<div class="ui basic segment center aligned">
			<button class="ui small button" @click="displayAll()">
				{{ this.locale === 'fr' ? "Tout afficher" : "Display all" }}
			</button>
			<button class="ui small button red" @click="displaySome('internship')">
				{{ this.locale === 'fr' ? "Stage" : "Internship" }}
			</button>
			<button class="ui small button purple" @click="displaySome('perso')">
				{{ this.locale === 'fr' ? "Personnel" : "Personal" }}
			</button>
			<button class="ui small button blue" @click="displaySome('esirem')">
				ESIREM
			</button>
		</div>
		<div class="ui divided items" v-if="projects.length !== 0">
			<div class="item" :class="project.category" v-for="project in projects" :key="project.index">
				<div class="image">
					<img class="ui rounded image" :src="require('../../assets/img/projects/' + (project.thumbnail !== undefined ? project.thumbnail
					!== '' ? project.thumbnail :'article.jpg' : 'article.jpg'))">
				</div>
				<div class="content">
					<a class="header">{{ project.title }}</a>
					<div class="meta">
						<div class="ui label red" v-if="project.category === 'intership'">{{ locale === 'fr' ? "Stage" : "Internship"}}</div>
						<div class="ui label purple" v-if="project.category === 'perso'">{{ locale === 'fr' ? "Personnel" : "Personal"}}</div>
						<div class="ui label blue" v-if="project.category === 'esirem'">ESIREM</div>
						<span>
							<i class="ui icon calendar"></i>
							{{ locale === 'fr' ? "Publié par Nicolas TOURRETTE le" : "Published by Nicolas TOURRETTE on" }} {{ project.date }}
						</span>
						<div class="extra">
							<i class="icon tags"></i>
							<div class="ui label" v-for="keyword in project.keywords" :key="keyword.key">{{
									keyword
								}}
							</div>
						</div>
					</div>
					<div class="description">
						<p class="text-justify" v-html="project.abstract"></p>
					</div>
					<div class="extra">
						<a class="ui primary button" :href="project.link">
							<i class="icofont-link"></i> Voir le détail du projet
						</a>
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
	name: "CVProjects.vue",
	props: ['locale'],
	data: function () {
		return {
			projects: [],
		}
	},
	created() {
		this.getProjects()
	},
	mounted: function () {
		this.displayTitle()
	},
	methods: {
		displayTitle: function () {
			if (this.locale === "fr") {
				document.title = `Compétences | ${this.$parent.$data.title}`
			} else {
				document.title = `Skills | ${this.$parent.$data.title}`
			}
		},
		getProjects: function () {
			$.ajax({
				url: `./assets/${this.locale}/cv/projects.json`,
				type: 'GET',
				dataType: "json",
				success: (response) => {
					this.projects = response
				},
				error: (response, status, error) => {
					this.projects = []
					throw new Error("Error when fetching the projects: ", error)
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
				console.warn(`No project to display in category ${toDisplay}`)
			}
			document.querySelectorAll(`div.ui.divided.items .item:not(.${toDisplay})`).forEach((item) => {
				item.classList.remove("visible")
				item.classList.add("hidden")
			})
		}
	},
	watch: {
		locale: function () {
			this.getProjects()
			this.displayTitle()
		}
	}
}
</script>

<style scoped>
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

.button {
	transition: transform .3s !important;
}

.button:hover {
	transform: scale(.95);
}
</style>