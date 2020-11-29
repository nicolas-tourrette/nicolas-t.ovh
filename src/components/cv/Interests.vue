<template>
	<div>
		<h1>{{ $t('Resume.Interests.Title') }}</h1>
		<div class="ui three column stackable grid">
			<div class="column" v-for="interest in interests" :key="interest.key">
				<div class="ui fluid card">
					<div class="content">
						<div class="header"><i :class="'icofont-' + interest.type"></i> {{ interest.title }}</div>
<!--						<div class="meta">Ami</div>-->
						<div class="description" v-html="interest.description"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	name: "CVInterests",
	props: ["locale"],
	data: function () {
		return {
			interests: []
		}
	},
	created: function () {
		this.fetchMyInfos()
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
		fetchMyInfos: function () {
			$.ajax({
				url: `./assets/${this.locale}/cv/interests.json`,
				type: 'GET',
				dataType: "json",
				success: (response) => {
					this.interests = response
				},
				error: (response, status, error) => {
					this.interests = []
					throw new Error("Error when fetching the information: ", error)
				}
			})
		}
	},
	watch: {
		locale: function () {
			this.displayTitle()
			this.fetchMyInfos()
		},
	}
}
</script>

<style scoped>
.ui.equal.grid {
	margin-bottom: 5px;
}

i[class*="icofont-"] {
	display: block;
	font-size: 300%;
	margin-bottom: 10px;
}

.card {
	transition: all .3s linear;
}

.card:hover {
	transform: scale(1.02);
	border: inherit;
	box-shadow: 0 10px 30px 0 rgba(0, 0, 0, 0.08);
}

.card:hover i[class*="icofont-"]:before{
	background: linear-gradient(to right, #1a4692 0%, #62bdfc 70%);
	-webkit-background-clip: text;
	-webkit-text-fill-color: transparent;
}

.card .content .header {
	font-variant: small-caps;
}
</style>