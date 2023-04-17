import { Address } from "./Address";
import { LegalStatus } from "./LegalStatus";

export class Company {
  id!: number;
  name!: string;
  siren!: string;
  registrationDate!: string;
  capital!: number;
  addresses!: Array<Address>;
  legalStatus!: LegalStatus;
}
