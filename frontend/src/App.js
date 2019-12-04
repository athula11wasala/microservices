import React,{Component} from 'react';
import { Form,FormGroup, 
         Label,FormText,
         FormFeedback,
         Input,Table,
         Button, Modal,
         ModalHeader,
         ModalBody,
         ModalFooter,
         Pagination,
         PaginationItem,
         PaginationLink } from 'reactstrap';
import axios from 'axios';
import configData from './VarConfig';

class App extends Component{

    axioReqest = axios.create({
    headers:configData.headers
  });
  
   state  = {
     categors : [],
     NewCategoryModal: false,
     EditCategoryModal: false,
     newCategoryData: {
       name:'',
       description : ''
      },
      editCategoryData: {
        id: '',
        name:'',
        description : ''
       }

   }
   toggleNewCategoryModal = () => {

       //this.addCategory();
       this.setState({
        NewCategoryModal :  !this.state.NewCategoryModal
       })

   }
   toggleEditCategoryModal = (id,name,description) => {
   
    this.setState({
      EditCategoryModal : !this.state.EditCategoryModal,
      editCategoryData: {
        id: id,
        name:name,
        description : description
       }
    })
}

 _refreshList(){

   this.axioReqest.get( configData.url + 'category/show-category')
                  .then((response) => {
                    this.setState({categors: response.data.data.data})
                  })
                  .catch((error) => {
                  })
 }

 deleteCategoryModal = (id) => {
     
  this.axioReqest.delete( configData.url + 'category/delete-category/' +id)
           .then((response) => {
              this._refreshList();
         })
         .catch((error) => {
    })
 }

editCategory = () => {
  
  this.axioReqest.put( configData.url + 'category/edit-category',this.state.editCategoryData,)
                .then((response) => {
            
                  this._refreshList();
          })
    .catch((error) => {
     })
 }

   addCategory = () => {
   
    this.axioReqest.post( configData.url + 'category/add-category',this.state.newCategoryData)
        .then((response) => {
        this._refreshList();
        })
        .catch((error) => {
    })
      
   }

   componentWillMount(){
   
     this._refreshList();
   }

  render(){
    
    let categoryRes = this.state.categors.map((data)=>{
      return(
        <tr key={data.id}>
             <td>{data.id}</td>
             <td>{data.name}</td>
             <td>{data.description}</td>
             <td>
               <Button  className='mr-2' color='success' size='sm'
                 onClick={this.toggleEditCategoryModal.bind(this,data.id,data.name,data.description)}
                >Edit</Button>
               <Button className='mr-2' color='danger' 
               onClick={this.deleteCategoryModal.bind(this,data.id)}
               size='sm' >Delete</Button>
            </td>
           </tr>
      )
    })
    return (
 
      <div className="App container">
       <Modal isOpen={this.state.EditCategoryModal} toggle={this.toggleEditCategoryModal.bind(this)}>
        <ModalHeader toggle={this.toggleEditCategoryModal.bind(this)}>Edit Category</ModalHeader>
        <ModalBody>
        <Form>
      <FormGroup>
      <Label for="exampleEmail">Name</Label>
        <Input type="text"  id='rating' value={this.state.editCategoryData.name} 
           name="email" id="exampleEmail" placeholder="with a placeholder" onChange={(e)=>{
               let {editCategoryData} = this.state;
               editCategoryData.name = e.target.value;
               this.setState({editCategoryData});
           }} />
      </FormGroup>
      <FormGroup>
      <Label for="exampleEmail">Description</Label>
        <Input type="text"  name="desc" id="exampleEmail" placeholder="with a placeholder"
          value={this.state.editCategoryData.description} 
          onChange={(e)=>{
            let {editCategoryData} = this.state;
            editCategoryData.description = e.target.value;
            this.setState({editCategoryData});
            console.log(this.state.editCategoryData);
          }}
        />
      </FormGroup>
      </Form>
        </ModalBody>
        <ModalFooter>
          <Button color="primary" onClick={this.editCategory.bind(this)}>Save</Button>{' '}
          <Button color="secondary" onClick={this.toggleEditCategoryModal.bind(this)}>Cancel</Button>
        </ModalFooter>
      </Modal>
    <Button color="primary" onClick={ this.toggleNewCategoryModal.bind(this)}>Add category</Button>
      <Modal isOpen={this.state.NewCategoryModal} toggle={this.toggleNewCategoryModal.bind(this)}>
        <ModalHeader toggle={this.toggleNewCategoryModal.bind(this)}>Add Category</ModalHeader>
        <ModalBody>
        <Form>
      <FormGroup>
      <Label for="exampleEmail">Name</Label>
        <Input type="text"  id='name' value={this.state.newCategoryData.title} 
           name="email" id="exampleEmail" placeholder="category" onChange={(e)=>{
               let {newCategoryData} = this.state;
               newCategoryData.name = e.target.value;
               this.setState({newCategoryData});
               console.log(this.state.newCategoryData);

           }} />
      </FormGroup>
      <FormGroup>
      <Label for="exampleEmail">Description</Label>
        <Input type="text" name="desc" id="exampleEmail" placeholder="description"
          value={this.state.newCategoryData.title}   
          onChange={(e)=>{
            let {newCategoryData} = this.state;
            newCategoryData.description = e.target.value;
            this.setState({newCategoryData});

          }}
        />
      </FormGroup>

      <FormGroup>
        <Label for="exampleEmail">Valid input</Label>
        <Input invalid type='text'  value="" />
        <FormFeedback>Oh noes! that name is already taken</FormFeedback>
        <FormText></FormText>
      </FormGroup>



      </Form>
        </ModalBody>
        <ModalFooter>
          <Button color="primary" onClick={this.addCategory.bind(this)}>Add</Button>{' '}
          <Button color="secondary" onClick={this.toggleNewCategoryModal.bind(this)}>Cancel</Button>
        </ModalFooter>
      </Modal>
        <Table>
          <thead>
            <tr>
              <th>#</th>
              <th>Permission</th>
              <th>Description</th>
              <th>Actions</th>
            </tr>
          </thead>
         <tbody>
           {categoryRes}
         </tbody>
       </Table>
      </div>
    )
}
}

export default App;
