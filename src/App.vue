<template>
	<div id="app">
		<MenuMobile @change-locale="changeLocale"></MenuMobile>
		<Sidebar @change-locale="changeLocale" ref="sidebar"></Sidebar>
		<div class="content">
			<div class="page">
				<transition name="component-fade" mode="out-in">
					<router-view :locale="this.locale" @software-info="getSoftInfo"></router-view>
				</transition>
			</div>
			<div class="footer">
				<Footer></Footer>
			</div>
		</div>
	</div>
</template>

<script>
import Sidebar from "./components/Sidebar.vue"
import Footer from "./components/Footer";
import MenuMobile from "./components/MenuMobile";

export default {
	name: 'App',
	components: {
		MenuMobile,
		Sidebar,
		Footer
	},
	data: function () {
		return {
			title: "Nicolas TOURRETTE",
			locale: navigator.language.substring(0, 2),
			versions: [],
			lastVersion: "",
			lastUpdated: "",
			lastContentUpdate: "",
		}
	},
	created: function () {
		this.getSoftInfo()
	},
	mounted: function () {
		//document.title = this.title
	},
	methods: {
		changeLocale(payload) {
			let locale = payload.locale
			this.locale = locale
			this.$parent.$i18n.locale = locale
			this.$refs.sidebar.updateLocale(locale)
		},
		getSoftInfo: function () {
			console.log("getting soft info")
			$.ajax({
				url: `./assets/software.json`,
				type: 'GET',
				dataType: "json",
				success: (response) => {
					this.lastVersion = response.versions[0].number
					this.lastUpdated = response.versions[0].date
					this.versions = response.versions
					this.lastContentUpdate = response.lastContentUpdate
					console.log(this.versions)
				},
				error: (response, status, error) => {
					this.news = []
					throw new Error("Error when fetching the software info: ", error)
				}
			})
		}
	},
	//watch: {}
}
</script>

<style>
#app {
	font-family: Lato, Helvetica, "Segoe UI", Arial, sans-serif;
	-webkit-font-smoothing: antialiased;
	-moz-osx-font-smoothing: grayscale;
	color: #2c3e50;
	margin: 0;
	padding: 0;
	overflow: hidden;
	height: 100vh;
	width: 100vw;
}

.content {
	margin-left: 15rem;
}

.page {
	overflow-y: auto;
	height: calc(100vh - 170px);
}

.footer {
	overflow-y: auto;
	overflow-x: hidden;
	width: 100vw;
	height: 170px;
}

@media (max-width: 768px) {
	.content {
		margin-left: 0;
		margin-top: 54px;
	}
	
	.page {
		height: calc(100vh - 100px - 54px);
	}
	
	.footer {
		height: 100px;
	}
	
	.footer .ui.container {
		margin-top: 0 !important;
	}
	
	.footer .ui.stackable.divided:not(.vertically).grid > .column:not(.row):first-child {
		padding-top: 1rem !important;
	}
}

.component-fade-enter-active, .component-fade-leave-active {
	transition: opacity .3s ease;
}

.component-fade-enter, .component-fade-leave-to {
	opacity: 0;
}
</style>
