<template>
	<div class="container">
		<h1 class="ui header blue">
			<img class="ui image" src="../assets/img/wedding.svg">
			<div class="content">
				<span>{{ this.locale === 'fr' ? "Mariage de Marion & Nicolas" : "Marion & Nicolas' Wedding" }}</span>
				<div class="sub header">
					{{ this.locale === 'fr' ? "Toutes les informations sur notre mariage." : "All the information about our wedding." }}<br>
					<small>{{ this.locale === 'fr' ? "Mis à jour : 16 juillet 2020." : "Last updated: July 16, 2020." }}</small>
				</div>
			</div>
		</h1>
		<img
			class="ui image centered rounded mariage"
			src="http://lacabananico.free.fr/srv/fiancailles/img/P1210725.jpg"
			alt="Mariage de Marion & Nicolas">
		<div class="ui two stackable cards">
			<div class="ui centered raised teal card">
				<div class="content">
					<div class="ui teal header text-center">Date</div>
				</div>
				<div class="content">
					<p>{{ this.locale === 'fr' ? "Notre mariage aura lieu le" : "Our wedding is planned on the" }}</p>
					<h3 class="ui text-center teal header">{{ this.locale === 'fr' ? "samedi 7 août 2021" : "Saturday, August 7th 2021" }}</h3>
					<p>{{ this.locale === 'fr'
						? "Nous vous attendons pour nous entourer durant cette belle journée !"
						: "We are waiting for you all to surround us for the beautifulest day of our lives!"
					}}</p>
					<p>{{ this.locale === 'fr'
						? "Afin de nous aider à l'organisation, cette page sera régulièrement mise à jour, n'hésitez pas à la consulter fréquemment."
						: "To help us, this page will be regularly updated, so please feel free to review it frequently."
					}}</p>
				</div>
			</div>
			<div class="ui centered raised teal card">
				<div class="content">
					<div class="ui teal header text-center">{{ this.locale === 'fr' ? "Lieux" : "Places" }}</div>
				</div>
				<div class="content">
					<p class="text-center">
						<i class="icofont-2x icofont-jewlery"></i><span class="hidden">15H &mdash;</span> {{ this.locale === 'fr' ? "Mairie" :
						"City hall" }}, 71260 LUGNY
					</p>
					<p class="text-center">
						<i class="icofont-2x icofont-jewlery"></i><span class="hidden">16H30 &mdash;</span> {{ this.locale === 'fr' ? "Église" :
						"Church" }},
						71118 SAINT-MARTIN-BELLE-ROCHE
					</p>
					<hr>
					<p class="text-center">
						<i class="icofont-2x icofont-cocktail"></i><span class="hidden">19H &mdash;</span> Carmel, 71118 SAINT-MARTIN-BELLE-ROCHE
					</p>
					<p class="text-center">
						<i class="icofont-2x icofont-dining-table"></i><span class="hidden">20H30 &mdash;</span> {{ this.locale === 'fr' ? `Salle
						des fêtes` : "Village hall" }}, 71000 SAINT-JEAN-LE-PRICHE
					</p>
				</div>
			</div>
		</div>
		<div class="hidden">
			<h2>Vous êtes invités ?</h2>
			<h4><i>Dites-nous si vous serez présents !</i></h4>
			<p>
				Afin de nous aider dans l'organisation de ce grand événement, dites-nous si vous serez présent !<br>
				<i>Les futurs mariés</i>
			</p>
			<div class="ui green icon message" id="mariage-validate-success"></div>
			<div class="ui red icon message" id="mariage-validate-error"></div>
			<form class="ui form">
				<h4 class="ui dividing header">Informations générales</h4>
				<div class="fields">
					<div class="six wide field required">
						<label for="nom">Votre nom</label>
						<input type="text" name="nom" id="nom" placeholder="Jean DUPONT" required>
					</div>
					<div class="five wide field required">
						<label for="telephone">Votre numéro de téléphone</label>
						<input type="tel" name="telephone" id="telephone" placeholder="01.23.45.67.89." required>
					</div>
					<div class="five wide field required">
						<label for="email">Votre e-mail</label>
						<input type="email" name="email" id="email" placeholder="jean.dupont@fai.fr" required>
					</div>
				</div>
				<h4 class="ui dividing header">Votre présence à notre mariage</h4>
				<div class="fields">
					<div class="four wide field required">
						<label for="nombre">Nombre de personnes présentes</label>
						<input type="number" name="nombre" id="nombre" value="2" required>
					</div>
					<div class="inline fields">
						<label for="presence">Vous serez présent à :</label>
						<div class="field">
							<div class="ui checkbox checked">
								<input type="checkbox" name="presence[]" value="mairie">
								<label>Cérémonie laïque à la mairie</label>
							</div>
						</div>
						<div class="field">
							<div class="ui checkbox">
								<input type="checkbox" name="presence[]" value="eglise">
								<label>Messe de mariage</label>
							</div>
						</div>
						<div class="field">
							<div class="ui checkbox">
								<input type="checkbox" name="presence[]" value="repas">
								<label>Repas de noces</label>
							</div>
						</div>
					</div>
				</div>
				<button class="ui green button" tabindex="0" type="submit">Finaliser</button>
				<button class="ui button" tabindex="0" type="reset">Annuler</button>
				<div class="ui error message"></div>
				<p>Nous collectons vos données personnelles afin de pouvoir organiser au mieux notre mariage. Ces données seront exclusivement
					réservées à notre usage propre et ne seront communiquées à aucun tiers.</p>
			</form>
		</div>
		<h2>Autres renseignements</h2>
		<p class="text-justify">Nous serons très heureux de vous avoir à nos côtés pour ce grand événement ! Cette page sera mise à jour dès que nous
			aurons des choses à vous dire sur notre mariage !</p>
		<p>{{ this.locale === 'fr'
			? "Si vous souhaitez nous écrire, vous pouvez envoyer un e - mail en cliquant ici :"
			: "If you want to write us an email, please click on that button:"
		}}</p>
		<div class="text-center"><a id="send-mariage-mail" class="ui yellow button"><i class="icofont-2x icofont-send-mail"></i></a></div>
	</div>
</template>

<script>
export default {
	name: "Mariage.vue",
	props: ['locale'],
	created() {
		if(document.querySelectorAll("link[href='https://fonts.googleapis.com/css?family=Sacramento&amp;display=swap']").length === 0){
			let sacramento = document.createElement('link')
			sacramento.setAttribute("href", "https://fonts.googleapis.com/css?family=Sacramento&amp;display=swap")
			sacramento.setAttribute("rel", "stylesheet")
			document.head.appendChild(sacramento)
		}
	},
	mounted: function () {
		this.displayTitle()
		$("a#send-mariage-mail").on("click", () => {
			document.location.href = "mailto:Mariage de Marion et Nicolas <mariagemarionnicolas@nicolas-t.ovh>"
		})
		$('.ui.checkbox').checkbox()
		$('.ui.form').on("submit", (event) => {
			event.preventDefault()
			if ($('.ui.form').form('is valid')) {
				this.formSend()
			}
		})
		this.formChecker()
	},
	methods: {
		displayTitle: function () {
			if (this.locale === "fr") {
				document.title = `Mariage de Marion et Nicolas | ${this.$parent.$data.title}`
			} else {
				document.title = `Marion & Nicolas' Wedding | ${this.$parent.$data.title}`
			}
		},
		formChecker: function () {
			$('.ui.form')
				.form({
					fields: {
						nom: {
							identifier: 'nom',
							rules: [
								{
									type: 'empty',
									prompt: 'Merci d\'entrer votre nom.'
								},
								{
									type: 'minLength[5]',
									prompt: 'Merci d\'entrer un nom d\'au moins 5 caractères.'
								}
							]
						},
						telephone: {
							identifier: 'telephone',
							rules: [
								{
									type: 'regExp',
									value: /([0-9][0-9]\.){5}$/gmi,
									prompt: 'Le numéro de téléphone est incorrect.'
								}
							]
						},
						email: {
							identifier: 'email',
							rules: [
								{
									type: 'regExp',
									value: /^((?!\.)[\w-_.]*[^.])(@[\w-]+)(\.\w+(\.\w+)?[^.\W])$/gmi,
									prompt: 'L\'adresse email est incorrecte.'
								}
							]
						},
						nombre: {
							identifier: 'nombre',
							rules: [
								{
									type: 'integer[1..100]',
									prompt: 'Veuillez saisir un nombre de personnes au moins égal à 1.'
								}
							]
						},
					}
				})
		},
		formSend: function () {
			let values = $('.ui.form').form('get values')
			values.presence = {
				"mairie": values.presence[0] === "mairie",
				"eglise": values.presence[1] === "eglise",
				"repas": values.presence[2] === "repas"
			}
			$.ajax({
				url: "api/mariage.php",
				type: "POST",
				data: "data=" + JSON.stringify(values),
				success: () => {
					$("#mariage-validate-error i.close.icon").click()
					$("#mariage-validate-success").html(`
						<i class="close icon"></i>
						<i class="check circle outline icon"></i>
						<div class="content" style="margin-left: 0;">
							<div class="header">Félicitations, c'est fait !</div>
							<p>Votre réponse nous est bien parvenue. Vous recevrez un e-mail à l'adresse ${values.email} pour vous donner un peu plus
							d'informations.</p>
							<p>Merci pour votre réponse. Si vous avez des questions, n'hésitez pas à nous joindre !</p>
						</div>
					`).removeClass("hidden").css("display", "flex")
					$('.message .close')
						.on('click', function () {
							$(this)
								.closest('.message')
								.transition('fade')
						})
				},
				error: (xhr, text, error) => {
					$("#mariage-validate-error").html(`
						<i class="close icon"></i>
						<i class="times circle outline icon"></i>
						<div class="content" style="margin-left: 0;">
						    <div class="header">Une erreur s'est produite !</div>
							<p>Une erreur s'est produite lors de l'enregistrement des informations... Nous en sommes désolés. Envoyez-nous directement un email avec l'erreur renvoyée.</p>
							<h4 class="ui horizontal divider header"><i class="icofont-info-circle"></i> Informations </h4>
							<p>Error: ${xhr.status} - ${error}</p></p>
						</div>
					`).removeClass("hidden").css("display", "flex")
					$('.message .close')
						.on('click', function () {
							$(this)
								.closest('.message')
								.transition('fade')
						})
				}
			});
		}
	},
	watch: {
		locale: function () {
			this.displayTitle()
		}
	}
}
</script>

<style scoped>
.ui.header {
	display: flex;
}

.ui.header .content {
	padding-left: .75rem;
	margin-left: 0;
	margin-top: 0;
	vertical-align: middle;
}

.ui.header .content span {
	font-family: 'Sacramento', cursive;
	font-size: 40px;
	line-height: 1.5;
}

.ui.header .content .sub.header small {
	font-size: 70%;
}

img.mariage {
	margin-top: 25px;
	margin-bottom: 30px;
	width: 50%;
	box-shadow: 0 0 10px #555;
}

#mariage-validate-success,
#mariage-validate-error {
	display: none;
}

#mariage-validate-success .content,
#mariage-validate-error .content {
	margin-left: 0 !important;
}

a.button {
	transition: transform .3s !important;
}

a.button:hover {
	transform: scale(.95);
}

@media (max-width: 768px) {
	.ui.header .content span {
		font-family: 'Sacramento', cursive;
		font-size: 40px;
		line-height: 1;
	}
	
	img.mariage {
		width: 100%;
	}
}
</style>