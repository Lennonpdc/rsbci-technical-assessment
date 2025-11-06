export interface TimeEntry {
  id: number
  project_id: number
  employee_id: number
  hours: number
  date: string
  project_name?: string
}
