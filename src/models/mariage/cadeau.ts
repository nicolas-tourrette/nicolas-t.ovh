export default class Cadeau {
	private _id: number
	private _nom: string
	private _prix: number
	private _reserve: boolean
	
	public get id(){ return this._id }
	public get nom(){ return this._nom }
	public get prix(){ return this._prix }
	public get reserve(){return this._reserve }
	
	public constructor(data: any = null) {
		this._id = 0
		this._nom = ""
		this._prix = 0.0
		this._reserve = false
		
		this.fromArray(data)
	}
	
	private fromArray(data: any = null){
		if(data){
			this._id = data.id !== undefined ? data.id : this._id;
			this._nom = data.cadeau !== undefined ? data.cadeau : this._nom;
			this._prix = data.prix !== undefined ? data.prix : this._prix;
			this._reserve = data.reserve !== undefined ? data.reserve : this._reserve;
		}
	}
	
	public toArray(): Object {
		return {
			id: this.id,
			nom: this.nom,
			prix: this.prix,
			reserve: this.reserve
		}
	}
	
	public reserveGift(){
		this._reserve = true
	}
}