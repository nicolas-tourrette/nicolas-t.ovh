export default class Cadeau {
	private _id: number
	private _nom: string
	private _prix: number
	private _description: string
	private _reserve: boolean
	private _montantParticipation: number
	private _lastParticipation: number
	
	public get id(){ return this._id }
	public get nom(){ return this._nom }
	public get prix(){ return this._prix }
	public get description(){ return this._description }
	public get reserve(){return this._reserve }
	public get montantParticipation(){ return this._montantParticipation }
	public get lastParticipation(){ return this._lastParticipation }
	
	public constructor(data: any = null) {
		this._id = 0
		this._nom = ""
		this._prix = 0.0
		this._description = ""
		this._reserve = false
		this._montantParticipation = 0.0
		this._lastParticipation = 0.0
		
		this.fromArray(data)
	}
	
	private fromArray(data: any = null){
		if(data){
			this._id = data.id !== undefined ? data.id : this._id;
			this._nom = data.cadeau !== undefined ? data.cadeau : this._nom;
			this._prix = data.prix !== undefined ? data.prix : this._prix;
			this._description = data.description !== undefined ? data.description : this._description;
			this._reserve = data.reserve !== undefined ? data.reserve : this._reserve;
			this._montantParticipation = data.montant_participation !== undefined ? data.montant_participation : this._montantParticipation
		}
	}
	
	public toArray(): Object {
		return {
			id: this.id,
			nom: this.nom,
			prix: this.prix,
			description: this.description,
			reserve: this.reserve,
			montant_participation: this.montantParticipation
		}
	}
	
	public reserveGift(){
		this._reserve = true
	}

	public participate(amount: number){
		console.log("amount:", typeof amount)
		console.log("montantPaticipation:", typeof this._montantParticipation)
		this._lastParticipation = amount
		this._montantParticipation = Number(this._montantParticipation) + Number(amount)
	}
}