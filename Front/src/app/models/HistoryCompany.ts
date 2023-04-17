export class HistoryCompany {
  id!: number;
  objectClass?: string;
  objectId?: string;
  username?: string;
  action?: string;
  data!: Array<any>;
  loggedAt!: string;
  version?: number;
}
