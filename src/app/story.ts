export class Story {
    id: number;
    name: string;
    content: string;
    feature_img: string;
    status: string;
    created_time: string;
    created_user: number;
    last_modified_time: string;
    last_modified_user: number;
    price: number;
    quantity: number;
    cat_ID: number;
    catname: string;
    constructor(feature_img: string,
        created_time: string,
        created_user: number,
        last_modified_time: string,
        last_modified_user: number,
        name: string,
        content: string,
        price: number,    
        quantity: number,
        catID: number,
        catname: string) {
            this.created_time=created_time;
            this.created_user=created_user;
            this.feature_img=feature_img;
            this.last_modified_time=last_modified_time;
            this.last_modified_user=last_modified_user;
            this.status='publish';
            this.content=content;
            this.name=name;
            this.price=price;
            this.quantity=quantity;
            this.cat_ID=catID;
            this.catname=catname;
    } 
}
